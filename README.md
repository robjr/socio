## Sinopse
Site rápido para administração de dados de sócios e empresas integrantes de um grupo. 

Para testar:
Login: admin
Senha: admin

## Instalação

Copiar a pasta do repositório para a pasta www do seu servidor Apache de modo que 
você irá acessar http://localhost/socio

É necessário que o sqlite esteja instalado e habilitado no php.ini, 
então verifique se existem os arquivos php_pdo_sqlite.ddl e php_sqlite3.dll.

Em seguida, no arquivo php.ini, tenha certeza que esta linha não está comentada: 

extension=php_pdo_sqlite.dll

E modifique o caminho a seguir, caso necessário, para o diretório onde se encontram 
as dlls mencionadas acima.

sqlite3.extension_dir = "C:\caminho\para\sqlite_dlls"

Login da aplicação: admin
Senha da aplicação: admin

## License

MIT License

Copyright (c) 2016 Roberto Júnior

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.