Olá. Esta é a documentação do Sistema de Agendamento, desenvolvido pelo SEDEPTI em 2018.

O Objetivo do sistema é cadastrar agendamentos de alunos onde estes terão reuniões com servidores. Para isso é necessário ter o Nome, Email, Telefone (opcional), Assunto (chamado de Curso/Programa), data e hora do agendamento. Do servidor, é necessário seu nome, seu email, seu telefone (opcional) e os horários para os quais ele está disponível. 

Os horários são pré-definidos e salvos no Banco de Dados. Um horário pode ter mais de um servidor disponível, e o sistema tem um algoritmo para identificar o servidor com menos agendamentos e assim receber o próximo, para que não haja discrepância de atarefamento.

Ao fazer o cadastramento, tanto o aluno, quanto o servidor recebem um email como comprovante. 

O servidor tem acesso à plataforma de Gerenciamento de Agendamentos. Onde ele pode:
 - Ver os agendamentos efetivos - há uma barra para pesquisa, onde o critério é qualquer match com o que ele escrever. 
- Cancelar um agendamento - quando este ocorrer, o aluno será notificado por email. O servidor só pode cancelar um agendamento quando ele for o responsável pelo mesmo. 
- Desabilitar/Reabilitar um dia - quando houver uma paralisação, ou um enforcamento de feriado etc.
- Fazer um agendamento, assim como aluno.
- Alterar seu perfil (seu nome, email, telefone, senha - todos servidores começam com senha padrão e devem mudar ao entrar pela primeira vez na plataforma - e seus horários de atuação).
- Enviar email para todos outros servidores (em breve), para comunicados importantes e referentes aos agendamentos.
- Ver suas estatísticas (em breve). Quantos agendamentos atendidos, cancelados, horários de pico etc.

Na plataforma também há o Administrador, onde este tem as mesmas características do servidor. Porém este pode cadastrar um novo servidor, além de poder cancelar qualquer agendamento.

O sistema tem 2 tipos de arquivos de configuração (pasta 'app') estilo (css) e funções (functions). Quanto às funções há 11 arquivos, do tipo .php e .js.
A necessidade de uma pasta chamada 'app' é para guardar os scripts que são muito utilizados na aplicação. 
- bdq.php: Está as configurações do banco de dados. Também conta com funções especiais para leitura no banco, além de uma genérica para update, delete, insert etc.
- custom.php: Há funções para facilitar transições e leituras. A mais utilizada é a redirect().
- deleta_linha.php: Aqui há um script para cancelar agendamentos.
- email.php: Aqui há o script para mandar emails. Utiliza-se a class PHPMailer com Composer.
- pages.php: Permite a utilização do '?page=' entre outras passagens de parâmetros via GET. Também há scripts para mensagens de erros e sucessos de operações.
- scriptAgendamento.js: Aqui há o script que controla o Datapicker (JQuery) e também para chamar o aparecimento das caixas de opções de horários. Tudo para a página de agendamento.
- SignOut.php: Aqui há o script para deslogar um usuário do sistema.
- validate.php: Aqui há um script para validar entradas de email, strings, números e senhas.
- vetHorarios: É chamado pelo scriptAgendamento.js. Aqui há o script para mostrar, adequadamente, se o dia está disponível e se há horários disponíveis para o dia escolhido. 

O sistema também conta com área destinada à visualização do público (pasta 'public'). Todos os arquivos são do formato .php e há 3 pastas principais e um arquivo.
- index.php: Página principal, onde todas as outras páginas (menos o admin.php) são contidas. Isto é, todo cabeçalho e funções em comum que são de todo o sistema, estão nesse arquivo, e o que realmente difere é que está em arquivos diferentes (estão na pasta 'pages').
- AdminLTE-master: Aqui são os componentes do layout (aquisição externa, isto é, não foi desenvolvido pela equipe do SEDEPTI, por isso o conhecimento sobre esta pasta são mínimos, apenas sobre aquilo que realmente utilizamos. O principal que foi utilizado foi o index.php que está na pasta 'pages' sob o nome 'admin.php') do sistema de Gerenciamento de Agendamentos.
- js-webshim: são componentes do AdminLTE-master. Nada de especial foi retirado ou modificado nessa pasta.
- pages: pasta onde estão os arquivos para as páginas e também a validação das mesmas.
A pasta 'pages' contém 13 arquivos, todos do formato .php, divididos em páginas(8) e arquivos de validação(5).
- admin.php: Já dito anteriormente, na sessão do AdminLTE-master.
- avisos.php: Ainda não desenvolvida, mas irá conter recursos para que o usuário do sistema possa mandar email para todos os servidores.
- CadastrarServidor.php: Oferece recursos para que o Administrador cadastre um novo servidor.
- contato.php: Oferece recursos para que alunos e servidores possam fazer cadastramentos.
- desabilitarDia.php: Oferece recursos para que o servidor possa desabilitar ou reabilitar um dia.
- estatistica.php: Ainda não desenvolvida. Irá oferecer recursos ao servidor para visualizar suas estastíticas quanto aos atendimentos.
- login.php: Oferece recursos para que o servidor possa fazer seu login ao sistema.
- profile.php: Oferece recursos para que o servidor possa configurar seu perfil.

Dentro da pasta 'forms' há arquivos de mesmo nome do qual este valida.
- CadastrarServidor.php: Oferece a validação, a inserção e inteligência necessária para cadastrar um novo servidor. Para fazê-lo, o Administrador coloca apenas o nome, email, telefone (opcional) e horários que este irá atuar. Ao concluir com sucesso, o servidor é comunicado via email.
- contato.php: Há uma avaliação de qual servidor será escolhido. Também a inserção do cadastro no banco de dados. Se concluído com sucesso, há o envio do email.
- desabilitarDia.php: Há a leitura da data inserida no banco de dados, se esta não existir, será inserida e o dia será desabilitado. Se retornar um valor do BD, então esta data será reabilitada. Também há um espaço para que o servidor justifique a desabilitação e reabilitação do dia.
- login.php: Há a leitura do email e da senha inseridos pelo usuário, se o email não existir, ele retorna um erro, se a senha não existir, também retorna um erro, se os dois existirem, mas não forem do mesmo servidor (todas as leituras retornam um id), retorna um erro. Se tudo ocorrer bem, será colocado em Session Storage os dados do servidor usados inicialmente no sistema e este é redirecionado à tela principal.
- profile.php: É verificado quais campos foram modificados pelo usuário, os  de caso verdadeiro serão modificados e atualizado o Session Storage. Há um script mais complexo para verificar os horários. Ele ler o enviado pelo usuário e o armazenado no banco, o que existir somente no enviado, será inserido; o que existir somente no banco de dados, será apagado. 

As tecnologias utilizadas na aplicação foram:
- HTML;
- CSS;
- Javascript;
- JQuery;
- PhP 5;
- Composer;
- ReCaptcha;
- MySQL (PhpMyAdmin);
- Debian 8 (Jessie);
- Trello;
- PHPMailer;
- Gmail (envios de emails);

Equipe SEDEPTI:
- Jairo Nascimento de Sousa Filho (Github: jairofilho79) Desde 14/03/2018 no projeto.
- Lucivaldo Gonçalves (Github: lucivaldojunior) Desde 14/03/2018 até 30/03/2018.