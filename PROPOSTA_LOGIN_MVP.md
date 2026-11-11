# Proposta de login e controle de acesso — MVP

**Status:** proposta para validação, sem implementação autorizada por este documento.

**Roteiro de desenvolvimento:** consulte o [Guia prático de implementação](GUIA_IMPLEMENTACAO_LOGIN_MVP.md). Ele traduz os requisitos abaixo em etapas, arquivos a alterar e formas de conferir o resultado, considerando a estrutura atual do projeto.

## 1. Objetivo e premissas

Validar o escopo de login e controle de acesso do MVP, considerando uma única organização e dois perfis: **Gestor e Associado**.

O login será realizado com e-mail e senha. O sistema identificará o perfil cadastrado e direcionará o usuário para sua área, sem necessidade de selecionar o tipo de acesso.

Cada gestor administrará somente as trilhas pelas quais é responsável e os conteúdos dessas trilhas. Também poderá atribuir associados às suas trilhas e remover essas atribuições.

O associado poderá visualizar somente as trilhas das quais é membro e consumir os conteúdos dessas trilhas. Não poderá criar, editar ou excluir trilhas, conteúdos ou usuários.

O gerenciamento dos cadastros de gestores e associados continuará pendente de definição. A atribuição a uma trilha não concederá permissão para alterar o cadastro do associado.

Nas tabelas abaixo, todo acesso de gestor ou associado exige autenticação. Os parâmetros entre chaves identificam o registro solicitado.

## 2. Entrada e autenticação

| Método | Rota | Função | Acesso |
|---|---|---|---|
| GET | `/` | Direcionar para `/login` ou `/home`, conforme a sessão | Todos |
| GET | `/login` | Exibir o formulário de login | Visitante |
| POST | `/login` | Validar as credenciais e o perfil e iniciar a sessão | Visitante |
| POST | `/logout` | Encerrar a sessão e direcionar para `/login` | Gestor e associado autenticados |
| GET | `/home` | Direcionar para `/trilhas`, com dados e ações conforme o perfil | Gestor e associado autenticados |

### Regras propostas

- Usuários já autenticados que acessarem `/login` serão encaminhados para `/home`.
- O perfil será obtido do cadastro, sem possibilidade de alteração pela tela de login.
- Credenciais inválidas não iniciarão uma sessão e apresentarão a mensagem: **“E-mail ou senha inválidos.”**
- Um cadastro sem perfil válido não terá acesso às áreas internas.
- A sessão será mantida durante a navegação até seu encerramento ou expiração.
- Após o logout, o acesso às páginas internas exigirá nova autenticação.
- O associado terá como página inicial a listagem “Minhas trilhas”. Quando não houver vínculos, será exibida a mensagem: **“Você ainda não possui trilhas disponíveis.”**
- Os dois perfis utilizarão as rotas de consulta de trilhas, com permissões e apresentação conforme o perfil.

## 3. Gestão de trilhas

| Método | Rota | Função | Acesso |
|---|---|---|---|
| GET | `/trilhas` | Listar as trilhas sob responsabilidade do gestor ou das quais o associado é membro | Gestor e associado, conforme seus vínculos |
| GET | `/trilhas/create` | Exibir o formulário de cadastro | Gestor |
| POST | `/trilhas` | Cadastrar uma trilha vinculada ao gestor conectado | Gestor |
| GET | `/trilhas/{trilha}` | Exibir os detalhes e os conteúdos da trilha | Gestor responsável ou associado membro |
| GET | `/trilhas/{trilha}/edit` | Exibir o formulário de edição | Gestor responsável |
| PUT | `/trilhas/{trilha}` | Atualizar a trilha | Gestor responsável |
| DELETE | `/trilhas/{trilha}` | Excluir a trilha | Gestor responsável |

### Regras propostas

- Cada gestor poderá acessar e administrar somente as trilhas pelas quais é responsável.
- Estar autenticado como gestor não concederá acesso às trilhas de outros responsáveis.
- Novas trilhas serão vinculadas automaticamente ao gestor conectado.
- A transferência de responsabilidade entre gestores ficará fora desta etapa.
- O associado poderá listar e consultar somente as trilhas das quais é membro.
- A participação em uma trilha não concederá ao associado permissão para criá-la, editá-la ou excluí-la.
- A tela de detalhes apresentada ao associado não disponibilizará ações administrativas nem a lista de membros da trilha.

## 4. Gestão de conteúdos

| Método | Rota | Função | Acesso |
|---|---|---|---|
| GET | `/conteudos` | Listar conteúdos das trilhas sob responsabilidade do gestor conectado | Gestor |
| GET | `/conteudos/create` | Exibir o formulário de cadastro, oferecendo apenas suas trilhas | Gestor |
| POST | `/conteudos` | Cadastrar conteúdo em uma de suas trilhas | Gestor responsável pela trilha |
| GET | `/conteudos/{conteudo}` | Exibir o conteúdo e permitir seu consumo, incluindo assistir a vídeos | Gestor responsável pela trilha ou associado membro |
| GET | `/conteudos/{conteudo}/edit` | Exibir o formulário de edição | Gestor responsável pela trilha |
| PUT | `/conteudos/{conteudo}` | Atualizar o conteúdo | Gestor responsável pela trilha |
| DELETE | `/conteudos/{conteudo}` | Excluir o conteúdo | Gestor responsável pela trilha |

### Regras propostas

- O conteúdo herdará a restrição de acesso da trilha à qual pertence.
- Se houver alteração da trilha de um conteúdo, o gestor deverá ser responsável tanto pela trilha original quanto pela trilha de destino.
- O associado acessará os conteúdos por dentro de suas trilhas. A listagem administrativa `/conteudos` permanecerá exclusiva do gestor.
- O associado poderá consumir os conteúdos das trilhas das quais é membro, mas não poderá cadastrar, editar ou excluir conteúdos.
- Novos conteúdos de uma trilha ficarão disponíveis aos seus membros sem necessidade de uma atribuição individual por conteúdo.

## 5. Atribuição e remoção de associados nas trilhas

Na tela de uma trilha sob sua responsabilidade, o gestor poderá abrir a área “Associados”, consultar os membros atuais, selecionar associados já cadastrados e remover vínculos existentes.

| Método | Rota | Função | Acesso |
|---|---|---|---|
| GET | `/trilhas/{trilha}/associados` | Exibir os membros atuais e os associados cadastrados disponíveis para atribuição | Gestor responsável pela trilha |
| POST | `/trilhas/{trilha}/associados` | Atribuir à trilha o associado identificado na requisição | Gestor responsável pela trilha |
| DELETE | `/trilhas/{trilha}/associados/{associado}` | Remover o vínculo do associado com a trilha | Gestor responsável pela trilha |

### Regras propostas

- O gestor somente poderá atribuir ou remover associados das trilhas pelas quais é responsável.
- Como proposta para esta organização única, o seletor oferecerá os associados já cadastrados na organização. Essa consulta exibirá apenas identificação, nome e e-mail para seleção, sem conceder acesso ao gerenciamento completo de usuários.
- Somente usuários do tipo Associado poderão ser selecionados como participantes.
- Uma trilha poderá ter vários associados e um associado poderá participar de várias trilhas, inclusive de responsáveis diferentes.
- Não poderá existir mais de um vínculo entre o mesmo associado e a mesma trilha.
- Após a atribuição, a trilha e seus conteúdos ficarão disponíveis ao associado nos próximos acessos.
- Após a remoção, a trilha deixará de aparecer para o associado e novas requisições à trilha ou aos seus conteúdos serão negadas, inclusive por links diretos.
- A remoção excluirá somente o vínculo com a trilha, preservando a conta do associado e seus vínculos com outras trilhas.
- Associados não poderão atribuir a si mesmos ou a outras pessoas, remover vínculos ou consultar a área de membros da trilha.

## 6. Gerenciamento de usuários — pendente de definição

As rotas abaixo já existem, mas suas permissões dependem da definição posterior da relação de gerenciamento entre gestores e associados.

| Método | Rota | Função | Proposta nesta etapa |
|---|---|---|---|
| GET | `/users` | Listar usuários | Bloqueada |
| GET | `/users/create` | Exibir formulário de cadastro | Bloqueada |
| POST | `/users` | Cadastrar usuário | Bloqueada |
| GET | `/users/{user}` | Exibir dados do usuário | Bloqueada |
| GET | `/users/{user}/edit` | Exibir formulário de edição | Bloqueada |
| PUT | `/users/{user}` | Atualizar usuário | Bloqueada |
| DELETE | `/users/{user}` | Excluir usuário | Bloqueada |

O bloqueio desse conjunto para visitantes, gestores e associados é uma **proposta para validação**, enquanto as permissões de gerenciamento não forem definidas. Nesta entrega, o login e a atribuição às trilhas utilizarão contas previamente cadastradas. O seletor de associados de uma trilha será atendido pela rota específica da seção anterior.

## 7. Acessos indevidos

As permissões serão verificadas no servidor em todas as operações, inclusive em acessos diretos por URL e no envio de requisições. A exibição de menus e botões acompanhará essas permissões.

| Situação | Resultado proposto |
|---|---|
| Visitante tenta abrir uma página protegida | Redirecionamento para `/login` |
| Visitante envia uma operação protegida | Operação não executada; autenticação exigida |
| Associado tenta criar, editar ou excluir trilhas e conteúdos, acessar a listagem administrativa de conteúdos ou gerenciar os membros de uma trilha | Acesso negado — `403` |
| Associado solicita uma trilha da qual não é membro ou um conteúdo dessa trilha | Recurso não disponibilizado — `404` |
| Gestor solicita uma trilha ou conteúdo de outro responsável | Recurso não disponibilizado — `404` |
| Gestor tenta consultar ou alterar os membros de uma trilha de outro responsável | Recurso não disponibilizado — `404`; nenhuma alteração executada |
| Usuário tenta acessar as rotas de gerenciamento de usuários | Acesso negado enquanto o módulo estiver bloqueado |
| Pessoa encerra a sessão e tenta acessar uma página interna | Novo login exigido |

## 8. Fora desta etapa

- Cadastro público e definição do processo de criação de contas.
- Definição das permissões de criação, edição e exclusão dos cadastros de gestores e associados.
- Recuperação de senha.
- Edição do próprio perfil e alteração de senha.
- Transferência de responsabilidade de trilhas.
- Progresso, conclusão de conteúdos, testes e bloqueio de etapas.
- Favoritos e pastas pessoais.
- Gestão de múltiplas organizações.

## 9. Critérios de aceite

- Um gestor com credenciais válidas entra e encontra somente suas trilhas.
- Um associado com credenciais válidas entra em “Minhas trilhas” e encontra somente as trilhas das quais é membro.
- Um associado sem vínculos encontra uma mensagem de que ainda não possui trilhas disponíveis.
- Um associado membro de uma trilha consegue abrir seus detalhes, acessar seus conteúdos e assistir aos vídeos disponíveis.
- Um associado não acessa trilhas das quais não é membro nem seus conteúdos, inclusive por links diretos.
- Credenciais inválidas não iniciam uma sessão.
- Um cadastro sem perfil válido não acessa as áreas internas.
- Uma pessoa desconectada não acessa páginas internas nem executa operações protegidas.
- Um associado não acessa as rotas administrativas de trilhas e conteúdos, inclusive por URL ou requisição direta.
- Um gestor não acessa nem altera trilhas ou conteúdos de outro responsável.
- Um conteúdo somente pode ser criado ou movido para uma trilha sob responsabilidade do gestor conectado.
- Um gestor consegue consultar, atribuir e remover associados de uma trilha sob sua responsabilidade.
- Um gestor não consegue consultar ou alterar membros de uma trilha de outro responsável.
- A atribuição do mesmo associado à mesma trilha não gera vínculos duplicados.
- Somente usuários do tipo Associado podem ser atribuídos como participantes.
- Após a remoção de um vínculo, novas requisições do associado à trilha e aos seus conteúdos são negadas, sem excluir sua conta ou afetar outras participações.
- Um associado não consegue consultar a área de membros, atribuir participantes ou remover vínculos.
- As rotas de gerenciamento de usuários permanecem bloqueadas, caso essa proposta seja aprovada.
- Após o logout, o acesso às páginas internas exige nova autenticação.

## 10. Validação solicitada

Podemos aprovar esta definição de rotas, funções e permissões como escopo para a posterior implementação do login do MVP, incluindo o consumo de trilhas pelos associados, a atribuição e remoção de associados pelo gestor responsável e o bloqueio temporário das rotas de gerenciamento de usuários?

Este documento registra uma proposta de planejamento. Sua criação não altera o comportamento atual da aplicação.
