ASOBU — catálogo de streaming/descoberta de jogos
=================================================

REQUISITOS
- PHP 8+ (com PDO MySQL; cURL é necessário para o aviso por Resend)
- MySQL/MariaDB e phpMyAdmin
- XAMPP ou ambiente local equivalente
- Conexão à internet para carregar fontes e imagens externas (o catálogo continua funcionando se as imagens externas falharem).

COMO INSTALAR NO XAMPP
1. Extraia a pasta "asobu_streaming" para C:\xampp\htdocs\
2. Abra o XAMPP e inicie Apache e MySQL.
3. Acesse http://localhost/phpmyadmin
4. Importe o arquivo database.sql (aba Importar).
5. Confira config.php. O padrão do XAMPP costuma ser usuário root e senha vazia.
6. Acesse http://localhost/asobu_streaming/

FUNCIONALIDADES
- Página inicial com catálogo local de 60 jogos (10 por categoria).
- 6 categorias com 10 jogos cada: Indie, Ação, Esportes, Corrida, Aventura e RPG.
- Busca e filtro de categoria em JavaScript sem recarregar a página.
- Página de detalhe por jogo.
- Cadastro e login com sessões PHP.
- Senhas armazenadas com password_hash e verificadas com password_verify.
- E-mail único no banco.
- Favoritos salvos no banco e protegidos por sessão.
- Recuperação de senha simulada, conforme permitido na atividade.
- Notificação de novo cadastro via API Resend (opcional até configurar as credenciais).

CONFIGURAR O RESEND
1. Crie/acesse sua conta em https://resend.com/
2. No modo de teste, use como destinatário o endereço permitido/verificado pela sua conta.
3. Abra config.php e altere:
   $resend_api_key = "re_...";
   $email_dono = "seu-email-verificado@...";
   $email_remetente = "Asobu <onboarding@resend.dev>";
4. Ative a extensão cURL no PHP se estiver desativada.
5. A chave fica somente no config.php; nunca coloque no HTML ou JavaScript.
O cadastro segue funcionando mesmo se o Resend não estiver configurado; nesse caso o aviso por e-mail é ignorado.

NOTAS PARA APRESENTAÇÃO
- Este é um catálogo de descoberta de jogos, não uma plataforma que transmite jogos ao vivo.
- O catálogo local não depende de API externa e mantém a apresentação funcionando.
- As imagens são URLs externas de demonstração; se alguma URL falhar, o fundo colorido do card permanece.
- Não inclua senhas reais nem a chave do Resend em repositório público.
- Antes de entregar, preencham os nomes de todos os integrantes no documento/entrega da turma.

IMAGENS E DESCRIÇÕES
- Cada jogo tem título, categoria, ano, nota, descrição e URL de imagem no arquivo games.php.
- As capas usam imagens de cabeçalho da Steam quando disponíveis e carregam pela internet.
- Para trocar uma imagem, altere o valor do campo "imagem" do jogo correspondente.
