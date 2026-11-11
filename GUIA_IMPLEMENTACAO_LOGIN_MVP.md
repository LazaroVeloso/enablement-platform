# Guia prático de implementação — login e acessos do MVP

Este guia transforma a [proposta de requisitos](PROPOSTA_LOGIN_MVP.md) em uma sequência de desenvolvimento para quem está aprendendo Laravel. A proposta continua sendo a referência das regras de negócio e das rotas.

**Situação:** planejamento. Os arquivos indicados como novos ainda deverão ser criados durante a implementação. Os comandos abaixo são instruções para essa etapa futura; não foram executados para produzir este documento.

## 1. Caminho recomendado para este projeto

Começar com **autenticação por sessão do próprio Laravel e telas Blade**. O projeto já usa controllers, models, formulários Blade e o guard `web`, que identifica o usuário por sessão. Isso permite acrescentar o login à estrutura existente.

Esta é a recomendação técnica deste guia. Não é necessário instalar um pacote de permissões, criar uma API ou introduzir outro framework de interface para cumprir os requisitos definidos.

A implementação será feita nesta ordem:

1. Preparar contas de desenvolvimento válidas.
2. Fazer login e logout funcionarem.
3. Diferenciar Gestor e Associado.
4. Preparar a relação entre associados e trilhas.
5. Aplicar as permissões às trilhas e aos conteúdos.
6. Permitir atribuir e remover associados.
7. Conferir o fluxo completo e automatizar os principais testes.

**O primeiro objetivo é entrar, manter a sessão e sair.** As regras de responsabilidade e participação entram depois que esse ciclo estiver funcionando localmente.

## 2. O que já existe e será aproveitado

Esta leitura foi feita nos arquivos do projeto, sem consultar os registros do banco nem testar os fluxos em execução.

| Parte existente | Onde está | Como será usada |
|---|---|---|
| Laravel | `composer.json` e `composer.lock` | O projeto exige Laravel `^13.17`; o lock registra `v13.26.1` |
| Rotas web | `routes/web.php` | Acrescentar autenticação e organizar os acessos |
| Configuração de middleware | `bootstrap/app.php` | Registrar a verificação de perfil e os redirecionamentos |
| Usuário autenticável | `app/Models/User.php` | Já estende `Authenticatable` e possui senha com cast `hashed` |
| Tipo do usuário | `User::tipo()` e `app/Models/Tipos.php` | Identificar Gestor e Associado usando a relação existente |
| Configuração de autenticação | `config/auth.php` | Já declara o guard `web` com sessão e o model `User` |
| Sessão | `config/session.php` e migration inicial de usuários | Existe configuração com padrão `database` e criação da tabela `sessions`; conferir a configuração efetiva no ambiente |
| Trilhas e conteúdos | `TrilhasController.php`, `ConteudosController.php` e seus models | Acrescentar filtros e verificações aos fluxos atuais |
| Participação em trilhas | Tabela `usuarios_has_trilhas`, declarada em migration | Aproveitar as colunas `usuarios_id` e `trilhas_id` |
| Telas | `resources/views/` | Adaptar as telas existentes e acrescentar login e membros da trilha |
| Estilos | `resources/css/app.css` e `package.json` | Aproveitar Tailwind e Vite já presentes |
| Testes | `tests/Feature/` e `phpunit.xml` | Acrescentar testes de autenticação e acesso |

### Conceitos que serão usados

- **Rota:** liga um endereço e um método HTTP a uma ação.
- **Controller:** recebe a requisição, coordena as verificações e devolve a resposta.
- **View Blade:** gera a página e seus formulários.
- **Model:** representa os dados e suas relações.
- **Sessão:** permite reconhecer a pessoa depois do login.
- **Middleware:** verifica uma condição antes de executar a ação, como estar autenticado.
- **Policy:** reúne as regras de acesso a um recurso, como uma trilha específica.
- **Migration:** registra uma alteração na estrutura do banco.
- **Seeder:** prepara dados, como contas fictícias para desenvolvimento.

## 3. Etapa 1 — preparar contas para aprender e conferir os acessos

**Objetivo:** ter contas conhecidas para testar cada perfil sem depender das rotas de gerenciamento de usuários, cujo bloqueio está proposto no escopo.

| Ação | Arquivo |
|---|---|
| Conferir os campos e a relação `tipo()` | `app/Models/User.php` |
| Conferir como os tipos são representados | `app/Models/Tipos.php` |
| Criar um seeder exclusivo de desenvolvimento | `database/seeders/UsuariosDesenvolvimentoSeeder.php` — novo |
| Posteriormente, completar os dados gerados pelos testes | `database/factories/UserFactory.php` |

### Passos

1. Conferir os nomes realmente cadastrados na tabela `tipos`. O código atual procura `gestor`, mas não há um seeder de tipos que comprove os demais nomes existentes. Padronizar o uso de `gestor` e `associado` na implementação; verificar eventuais registros antigos de vendedor antes de modificá-los.
2. Criar os tipos necessários no ambiente de desenvolvimento, sem depender de IDs fixos como “1 é gestor”. Consultar os tipos pelo nome e usar seus IDs reais.
3. Preparar dois gestores e dois associados fictícios, com e-mails diferentes, CPF único, senha e `tipos_id` válido. Essas contas são exemplos de teste, não novos perfis do produto.
4. Usar o model `User` para cadastrar as contas, aproveitando o cast de senha já existente. Não comparar senhas diretamente com o valor armazenado no banco.

O `DatabaseSeeder.php` atual cria um usuário de exemplo com a factory padrão. Essa factory não informa `cpf` e `tipos_id`, embora a migration `2026_08_29_195702_add_cpf_and_tipo_to_users_table.php` os exija. Portanto, não presumir que o seeder atual já prepara as contas necessárias.

Comandos para quando esta etapa for implementada:

```bash
php artisan migrate:status
php artisan make:seeder UsuariosDesenvolvimentoSeeder
```

Depois de preencher o novo seeder e conferir que o banco é o de desenvolvimento:

```bash
php artisan db:seed --class=UsuariosDesenvolvimentoSeeder
```

Não é necessário apagar o banco para preparar essas contas. Evitar usar `migrate:fresh` como tentativa de correção: ele elimina as tabelas. A migration que adiciona CPF e tipo também possui um `down()` que remove `users`; revisar esse comportamento antes de qualquer rollback.

**Como conferir:** cada conta de teste possui um tipo válido e todos os campos obrigatórios. Não registrar senhas reais no repositório.

## 4. Etapa 2 — fazer login e logout funcionarem

**Objetivo:** provar o fluxo básico de sessão antes de trabalhar nas permissões das trilhas.

| Ação | Arquivo |
|---|---|
| Criar as ações de login e logout | `app/Http/Controllers/AuthController.php` — novo |
| Criar o formulário | `resources/views/auth/login.blade.php` — novo |
| Declarar as rotas | `routes/web.php` |
| Configurar o destino de visitantes e usuários conectados | `bootstrap/app.php` |
| Usar uma página simples para conferir a sessão nesta etapa | `resources/views/home/index.blade.php` |
| Acrescentar um botão de sair para usuários conectados | `resources/views/layouts/app.blade.php` |

Pode-se gerar o controller com:

```bash
php artisan make:controller AuthController
```

### Rotas a ligar ao controller

| Método | Rota | Nome proposto | Ação |
|---|---|---|---|
| GET | `/login` | `login` | `AuthController::create` |
| POST | `/login` | `login.store` | `AuthController::store` |
| POST | `/logout` | `logout` | `AuthController::destroy` |

### O que cada ação fará

**`create`:** devolver a view `auth.login`, com e-mail, senha, botão Entrar e mensagens de erro. O formulário enviará `POST` para `login.store` e terá `@csrf`, como os formulários existentes.

**`store`:** validar e-mail e senha, tentar autenticar com `Auth::attempt`, conferir se o tipo é permitido e regenerar a sessão no sucesso. Se o tipo for inválido após a tentativa, encerrar e invalidar a sessão antes de devolver o erro. Em falha, mostrar “E-mail ou senha inválidos.” e manter apenas o e-mail preenchido. Direcionar o sucesso para `home.index`.

**`destroy`:** chamar `Auth::logout()`, invalidar a sessão, regenerar o token CSRF e direcionar para `login`. O botão Sair deverá ser um formulário `POST` com `@csrf`.

Esse fluxo utiliza os mecanismos descritos na [documentação de autenticação do Laravel](https://laravel.com/docs/13.x/authentication#manually-authenticating-users).

### Proteção inicial

- Aplicar `guest` às rotas de login e `auth` às rotas internas. O primeiro identifica quem ainda não entrou; o segundo exige uma sessão autenticada.
- Em `bootstrap/app.php`, usar `redirectGuestsTo` para `/login` e `redirectUsersTo` para `/home`. A configuração deste projeto fica nesse arquivo, não em um `Http/Kernel.php` a ser criado.
- Acrescentar limitação de tentativas ao `POST /login` usando o middleware nativo `throttle`. Como escolha técnica inicial, pode-se começar com cinco tentativas por minuto e conferir a mensagem quando esse limite for atingido.
- Manter `/users` e suas operações bloqueadas no servidor, conforme a proposta. Preservar seus nomes de rota e retornar `403` após autenticação é uma forma simples de manter o bloqueio explícito. Retirar o link “Usuários” da navegação.
- Enquanto as permissões de trilhas e conteúdos não estiverem prontas, manter essas operações temporariamente bloqueadas durante esta montagem local. O teste de login pode terminar na página inicial simples, sem listar dados.

Os aliases `auth`, `guest` e `throttle` já são fornecidos pelo Laravel. Veja a [documentação de middleware](https://laravel.com/docs/13.x/middleware#middleware-aliases).

**Como conferir:** entrar com uma conta válida, atualizar a página e continuar conectado; testar senha incorreta; sair e tentar abrir `/home` novamente. O navegador deve exigir novo login. Testar também uma conta com tipo inválido e confirmar que não fica autenticada.

## 5. Etapa 3 — reconhecer os dois perfis

**Objetivo:** distinguir o tipo de acesso sem espalhar números de tipos pelos controllers.

| Ação | Arquivo |
|---|---|
| Criar os métodos auxiliares `isGestor()` e `isAssociado()` | `app/Models/User.php` |
| Criar a verificação dos perfis permitidos | `app/Http/Middleware/VerificarTipo.php` — novo |
| Registrar o alias `tipo` | `bootstrap/app.php` |
| Organizar os grupos de rotas | `routes/web.php` |

Os métodos do usuário deverão consultar o nome pela relação existente, usando `$this->tipo?->nome`, e compará-lo com os nomes padronizados na etapa 1. O operador `?->` permite lidar com a ausência de tipo; nessa situação, os métodos deverão retornar falso.

```bash
php artisan make:middleware VerificarTipo
```

O middleware receberá os tipos permitidos. Nas rotas compartilhadas, usar a ideia de `auth` seguido de `tipo:gestor,associado`; nas administrativas, `auth` seguido de `tipo:gestor`. Registrar esse alias dentro de `withMiddleware` em `bootstrap/app.php`.

Manter o logout protegido por `auth`, sem depender de um tipo válido: uma pessoa deve conseguir encerrar sua sessão mesmo se seu cadastro tiver sido alterado.

**Atenção à diferença:** esse middleware verifica o perfil. A responsabilidade por uma trilha e a participação nela serão verificadas na etapa 5.

**Como conferir:** o associado recebe `403` ao tentar abrir uma rota administrativa; o gestor passa pela verificação de perfil. Ainda não liberar os dados sem as verificações de cada recurso.

## 6. Etapa 4 — preparar a participação nas trilhas

**Objetivo:** permitir que o Laravel consulte quais associados pertencem a cada trilha e vice-versa.

| Ação | Arquivo |
|---|---|
| Criar a relação `trilhasParticipantes()` | `app/Models/User.php` |
| Criar a relação `associados()` | `app/Models/Trilhas.php` |
| Revisar a estrutura antiga de vínculo | `app/Models/Usuario_has_trilhas.php` e métodos `tabelaResponsavel()` |
| Impedir vínculos duplicados no banco | Nova migration em `database/migrations/` |

A tabela `usuarios_has_trilhas` já foi declarada na migration `2026_08_24_231946_create_usuarios_has_trilhas.php`. Não criar outra tabela para a mesma finalidade. Essa relação é de muitos para muitos: uma trilha tem vários associados e um associado pode participar de várias trilhas.

Exemplo do relacionamento a acrescentar em `User.php`:

```php
public function trilhasParticipantes()
{
    return $this->belongsToMany(
        Trilhas::class,
        'usuarios_has_trilhas',
        'usuarios_id',
        'trilhas_id'
    )->withTimestamps();
}
```

Em `Trilhas.php`, o relacionamento inverso será `associados()`, apontando para `User::class`, com `trilhas_id` como chave do model atual e `usuarios_id` como chave do model relacionado. Referência: [relações muitos para muitos](https://laravel.com/docs/13.x/eloquent-relationships#many-to-many).

### Correções necessárias nesta etapa

- Os métodos `tabelaResponsavel()` atuais apontam para `UsuarioHasTrilhas`, mas o model existente se chama `Usuario_has_trilhas`.
- O model de vínculo declara `tabela_id`, enquanto a migration declara `trilhas_id`.
- Para este guia, usar diretamente `belongsToMany` e substituir as relações incompletas após verificar suas referências. Não é necessário criar outro model de vínculo para usar essa abordagem.
- Manter `Trilhas::responsavel()`: ele identifica o gestor responsável e é diferente da participação dos associados.
- Criar uma migration nova com índice único para o par `usuarios_id` e `trilhas_id`. Antes de aplicá-la, conferir se já há pares repetidos no banco e resolver essas duplicidades preservando uma participação por par.

Comando sugerido para gerar a migration:

```bash
php artisan make:migration add_unique_usuario_trilha_to_usuarios_has_trilhas_table --table=usuarios_has_trilhas
```

**Como conferir:** em dados de desenvolvimento, vincular um associado a uma trilha e confirmar que as duas relações encontram o mesmo vínculo. Não usar `responsavel_id` para representar o associado.

## 7. Etapa 5 — aplicar as permissões e adaptar as telas

**Objetivo:** liberar cada pessoa somente para os registros e ações permitidos na proposta.

As policies serão introduzidas agora, depois do login básico. Elas permitem concentrar as regras usadas pelos controllers e pelos botões das telas.

| Ação | Arquivo |
|---|---|
| Criar as regras das trilhas | `app/Policies/TrilhasPolicy.php` — novo |
| Criar as regras dos conteúdos | `app/Policies/ConteudosPolicy.php` — novo |
| Registrar a relação entre cada model e sua policy | `app/Providers/AppServiceProvider.php` |
| Aplicar filtros e permissões | `app/Http/Controllers/TrilhasController.php` e `ConteudosController.php` |
| Ajustar a navegação final | `app/Http/Controllers/HomeController.php` e `routes/web.php` |
| Adaptar as páginas | `resources/views/trilhas/`, `resources/views/conteudos/` e `resources/views/layouts/app.blade.php` |

```bash
php artisan make:policy TrilhasPolicy --model=Trilhas
php artisan make:policy ConteudosPolicy --model=Conteudos
```

Em `AppServiceProvider::boot`, registrar explicitamente os pares `Trilhas` → `TrilhasPolicy` e `Conteudos` → `ConteudosPolicy` com `Gate::policy`.

### Regras a escrever nas policies

| Ação | Regra |
|---|---|
| Listar trilhas (`viewAny`) | Gestor ou associado; o controller ainda precisa filtrar os registros |
| Consultar trilha (`view`) | Gestor responsável ou associado membro |
| Criar trilha (`create`) | Gestor |
| Editar ou excluir trilha (`update`, `delete`) | Gestor responsável |
| Gerenciar membros (`gerenciarAssociados`) | Gestor responsável |
| Listar ou criar conteúdos (`viewAny`, `create`) | Gestor; o cadastro também verificará a trilha de destino |
| Consultar conteúdo (`view`) | Pessoa com acesso à trilha correspondente |
| Editar ou excluir conteúdo (`update`, `delete`) | Gestor responsável pela trilha |

Para perfil proibido em uma ação administrativa, retornar `403`. Para uma trilha ou conteúdo fora dos vínculos permitidos, retornar `404`. Nas policies, `Response::denyAsNotFound()` permite representar essa segunda situação. O controller deve chamar `Gate::authorize` antes de mostrar, modificar ou excluir o registro. Referência: [autorização com policies](https://laravel.com/docs/13.x/authorization).

O controller base atual (`app/Http/Controllers/Controller.php`) está vazio. Por isso, este roteiro usa a facade `Gate`, sem presumir que `$this->authorize()` já esteja disponível.

### Mudanças nos controllers existentes

| Local | O que fazer |
|---|---|
| `TrilhasController::index` | Para gestor, filtrar por `responsavel_id` igual ao usuário conectado. Para associado, consultar `trilhasParticipantes()` |
| `TrilhasController::show` | Autorizar `view` antes de devolver a tela |
| `TrilhasController::create` e `store` | Autorizar criação; definir `responsavel_id` no servidor com o ID do gestor conectado |
| `TrilhasController::edit` e `update` | Autorizar edição; não aceitar troca de responsável pelo formulário |
| `TrilhasController::destroy` | Autorizar exclusão; remover os vínculos de participação antes da trilha, dentro de uma transação |
| `ConteudosController::index` | Filtrar os conteúdos pela responsabilidade da trilha |
| `ConteudosController::create` e `edit` | Oferecer somente as trilhas do gestor no seletor |
| `ConteudosController::store` | Autorizar criação e conferir no servidor que `trilhas_id` pertence ao gestor |
| `ConteudosController::show` | Autorizar consulta por meio da trilha do conteúdo |
| `ConteudosController::update` | Autorizar o conteúdo atual e conferir a responsabilidade pela trilha de destino |
| `ConteudosController::destroy` | Autorizar exclusão antes de apagar |

No vínculo de participação atual, a chave estrangeira não declara exclusão em cascata. Por isso, excluir uma trilha com membros precisa tratar esses vínculos. A migration de conteúdos já declara exclusão em cascata quando a trilha é removida. Não excluir as contas dos participantes.

### Mudanças nas views e rotas

1. Corrigir `resources/views/trilhas/create.blade.php`: o formulário atual aponta para `trilhas.create` e usa `@method('PUT')`. O cadastro deve enviar `POST` para `trilhas.store`, com `@csrf` e sem simular `PUT`.
2. Retirar o seletor de responsável de `trilhas/create.blade.php` e `trilhas/edit.blade.php`. A responsabilidade será determinada ou preservada pelo servidor.
3. Em `trilhas/index.blade.php`, apresentar “Minhas trilhas” para o associado e uma mensagem quando a lista estiver vazia.
4. Em `trilhas/index.blade.php`, `trilhas/show.blade.php` e `conteudos/show.blade.php`, condicionar os botões administrativos às policies, usando `@can`.
5. Manter a exibição de conteúdo já existente em `conteudos/show.blade.php`. O player atual usa `iframe`, e o model `Conteudos` já converte determinados links do YouTube. Este trabalho não exige criar outro player.
6. Alterar `HomeController::index` para redirecionar à rota `trilhas.index`. A antiga tela inicial deixa de ser o destino final do login.
7. Fazer `/` direcionar visitantes para `/login` e usuários conectados para `/home`.
8. Em `routes/web.php`, manter as consultas compartilhadas e as operações administrativas no grupo de gestor. Declarar `/trilhas/create` antes de `/trilhas/{trilha}` e `/conteudos/create` antes de `/conteudos/{conteudo}`.

Um campo selecionável na tela não garante autorização. As verificações de responsabilidade também precisam acontecer ao receber os dados enviados.

**Como conferir:** usar os dois gestores e os dois associados. Testar listas, detalhes e ações usando também URLs de registros pertencentes à outra pessoa. Conferir que os botões e as respostas do servidor obedecem às mesmas regras.

## 8. Etapa 6 — atribuir e remover associados

**Objetivo:** o gestor controlar a participação nas próprias trilhas.

| Ação | Arquivo |
|---|---|
| Criar as ações de membros | `app/Http/Controllers/TrilhaAssociadoController.php` — novo |
| Criar a tela de membros e o seletor de associados | `resources/views/trilhas/associados.blade.php` — novo |
| Acrescentar as três rotas | `routes/web.php` |
| Acrescentar o botão “Associados” | `resources/views/trilhas/show.blade.php` |

```bash
php artisan make:controller TrilhaAssociadoController
```

| Método | Rota | Ação | Nome proposto |
|---|---|---|---|
| GET | `/trilhas/{trilha}/associados` | `TrilhaAssociadoController::index` | `trilhas.associados.index` |
| POST | `/trilhas/{trilha}/associados` | `TrilhaAssociadoController::store` | `trilhas.associados.store` |
| DELETE | `/trilhas/{trilha}/associados/{associado}` | `TrilhaAssociadoController::destroy` | `trilhas.associados.destroy` |

As três rotas exigirão `auth`, perfil gestor e autorização `gerenciarAssociados` sobre a trilha. O parâmetro `{associado}` representa um `User` existente; não é necessário criar outro model de usuário. Além de encontrar a conta, conferir seu tipo e seu vínculo com a trilha.

### Passos por ação

**`index`:** listar membros atuais e associados disponíveis para inclusão. Consultar apenas usuários do tipo Associado; apresentar somente identificação, nome e e-mail. Não liberar `/users` para construir esse seletor.

**`store`:** receber um campo `associado_id`, validar que a conta existe e é do tipo Associado, autorizar a trilha e acrescentar o vínculo. Usar a relação `associados()` com `syncWithoutDetaching([$associadoId])`, mantendo os membros que já estavam na trilha. O índice único da etapa 4 também deve impedir duplicação.

**`destroy`:** autorizar a trilha, conferir o vínculo e usar `associados()->detach($associado->id)`. Isso remove a participação, preservando a conta e as demais trilhas do associado. Referência: [operações de vínculo no Eloquent](https://laravel.com/docs/13.x/eloquent-relationships#syncing-associations).

Após adicionar ou remover, voltar à tela de membros com uma mensagem de sucesso. Formulários de inclusão usam `POST` e `@csrf`; formulários de remoção usam `POST`, `@csrf` e `@method('DELETE')`.

**Como conferir:** adicionar um associado, entrar com sua conta e abrir a trilha e um conteúdo. Depois, remover a participação com o gestor e repetir o acesso do associado. As próximas requisições devem ser negadas. Confirmar que as outras participações continuam disponíveis.

## 9. Etapa 7 — conferir o conjunto

Criar os testes por etapa, conforme cada comportamento começar a funcionar. Para este escopo, os testes importantes são os de acesso por requisição, porque verificam também tentativas que não passam pelos botões da tela.

### Arquivos de teste sugeridos

| Arquivo novo | Comportamentos a verificar |
|---|---|
| `tests/Feature/AuthenticationTest.php` | Login correto, senha errada, tipo inválido, visitante em página protegida, limite de tentativas e logout |
| `tests/Feature/TrilhasAccessTest.php` | Listagem filtrada, consulta por vínculo, acesso negado a outra trilha e proibição de ações administrativas pelo associado |
| `tests/Feature/ConteudosAccessTest.php` | Consumo autorizado, conteúdo sem vínculo, operações de outro gestor e mudança para trilha de destino não permitida |
| `tests/Feature/TrilhaAssociadosTest.php` | Inclusão, remoção, duplicidade, usuário de tipo incorreto, gestor sem responsabilidade e perda de acesso após remoção |

Os testes devem usar dados próprios. O `phpunit.xml` atual declara SQLite em memória e sessão em `array`; conferir essa configuração ao preparar os testes. Ajustar `UserFactory.php` para gerar CPF único e permitir informar um tipo válido existente, sem presumir IDs fixos.

Usar `RefreshDatabase` nos testes que precisam das tabelas. O `tests/Feature/ExampleTest.php` atual espera status `200` para `/`; adaptá-lo para o redirecionamento definido neste escopo.

Comandos para conferir a implementação quando ela existir:

```bash
php artisan route:list
php artisan test
```

Na conferência manual, testar também adulteração de IDs enviados nos formulários. Por exemplo: um gestor tentar criar conteúdo em uma trilha de outro responsável. O servidor deve rejeitar a operação mesmo que essa trilha não apareça no seletor.

O roteiro estará concluído quando os critérios de aceite da [proposta](PROPOSTA_LOGIN_MVP.md) forem atendidos, incluindo o bloqueio do gerenciamento de usuários previsto nela.

## 10. Limites e decisões ainda abertas

- O guia não implementa cadastro público, recuperação de senha, edição de perfil, progresso, testes de aprendizagem, favoritos ou pastas. Esses itens continuam fora do escopo da proposta.
- O bloqueio das rotas de usuários e a seleção de associados de toda a organização continuam registrados como propostas para validação. Uma mudança nessas decisões exige ajustar este roteiro.
- O código possui `ativo`, `data_inicio` e `data_fim` nas trilhas, mas a proposta não define se esses campos bloqueiam o acesso. Este guia aplica as regras de perfil, responsabilidade e participação; uma restrição adicional por situação ou prazo precisa de definição de produto.
- A autorização descrita protege as páginas e operações do sistema. O player existente carrega links externos; essas verificações não alteram a privacidade do vídeo no serviço que o hospeda.

## 11. Por onde começar na primeira sessão de desenvolvimento

Realizar a etapa 1 e depois trabalhar somente em `AuthController.php`, `auth/login.blade.php`, `routes/web.php`, `bootstrap/app.php` e na página de conferência da sessão. Encerrar esse primeiro ciclo quando for possível entrar, atualizar a página, sair e ter o próximo acesso protegido redirecionado ao login.

Em seguida, avançar para os perfis, os vínculos e as permissões na ordem apresentada. Os arquivos de aplicação e as alterações no banco serão produzidos nessa implementação futura; este documento é o roteiro para executá-la.
