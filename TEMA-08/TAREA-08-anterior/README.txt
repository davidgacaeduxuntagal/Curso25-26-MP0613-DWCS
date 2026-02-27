Recuerda configurar el virtual host de Apache2 para esto correctamente:


1) Deshabilitar (comentar las líneas que son o se parecen a las siguientes) el virtual host por defecto (que sirve /htdocs)

## [web por defecto de XAMPP: htdocs]
## Cambiar la ruta de DocumentRoot y Directory a la de tu instalación concreta, si difieren
## <VirtualHost *:80>
##   ServerAdmin webmaster@dwcs.localhost
##   DocumentRoot "C:/xampp-8-2-12/htdocs"
##   ServerName localhost
##   ServerAlias 127.0.0.1
##   <Directory "C:/xampp-8-2-12/htdocs">
##     Options Indexes FollowSymLinks Includes ExecCGI
##     Require all granted
##     AllowOverride All
##   </Directory>
##   ErrorLog "logs/htdocs.localhost.log"
##   CustomLog "logs/htdocs.localhost-access.log" common
## </VirtualHost>



2) Habilitar: (ver por favor EJEMPLO-httpd-vhosts.conf en la raíz de este repo)

## -------------------------------------------------------------------------------------
## ESTE SOLO SE HABILITA PARA PRUEBAS CON GOOLE APIs
## -------------------------------------------------------------------------------------
##  PUES NO ADMITEN SUBDOMINIOS DE localhost (dwcs.localhost, etc): SOLO http://localhost
## SE DEBE DESHABILITAR EL OTRO VIRTUAL HOST DE LA CARPETA POR DEFECTO DE APACHE EN XAMPP
##  MIENTRAS SE USE ESTE
<VirtualHost *:80>
  ServerAdmin webmaster@dwcs.localhost
  DocumentRoot "${Curso24-25-MP0613-DWCS}"
  ServerName localhost
  ServerAlias 127.0.0.1
  <Directory "${Curso24-25-MP0613-DWCS}">
	Options Indexes FollowSymLinks Includes ExecCGI
	Require all granted
	AllowOverride All
  </Directory>
  ErrorLog "logs/htdocs-tema08.localhost.log"
  CustomLog "logs/htdocs-tema08.localhost-access.log" common
</VirtualHost>