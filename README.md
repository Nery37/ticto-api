# API Documentation

## Recursos da API

- **Framework**: Laravel 11
- **Banco de Dados**: MySQL 8
- **Autenticação**: JWT (usando `tymon/jwt-auth`)
- **Docker**: Configuração para ambiente Docker, incluindo serviços como MySQL
- **Documentação**: Collection do Postman disponível na pasta `collection` para facilitar os testes de API

## Postman Collection

Para facilitar os testes e integração com a API, uma collection do Postman está incluída na pasta `collection`. Importe essa collection no Postman para acessar todos os endpoints e parâmetros necessários.

## Configuração Inicial do Projeto

1. Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário, como detalhes do banco de dados, chave JWT, entre outros.
2. Execute os seguintes comandos `make` para configurar e iniciar o projeto.

### Comando `make`

- **install**: Executa uma série de ações para configurar o projeto. Inclui recriar os containers, instalar dependências via Composer e executar migrations e seeders.
  
  ```
  make install
  ```

## Frontend do Projeto

Este projeto possui um frontend separado desenvolvido em **Vue.js 2**. O repositório do frontend contém todas as interfaces e componentes necessários para consumir esta API.

- **Repositório do Frontend**: [TICTO-FRONTEND](https://github.com/exemplo/frontend-vue2)

Certifique-se de seguir as instruções no repositório do frontend para configurá-lo e conectá-lo a esta API.

## Autenticação

### Login
- **Endpoint:** `/api/auth/login`
- **Método:** `POST`
- **Descrição:** Autentica um usuário e retorna um token JWT.

#### Parâmetros:
| Parâmetro    | Tipo   | Obrigatório | Descrição           |
|--------------|--------|-------------|---------------------|
| `email`      | string | Sim         | Email do usuário.   |
| `password`   | string | Sim         | Senha do usuário.   |

#### Exemplo de Resposta:
```
{
    "data": {
        "access_token": "jwt_token_aqui",
        "token_type": "bearer"
    }
}
```

### Alterar Senha

- **Endpoint:** `/api/auth/change-password`
- **Método:** `POST`
- **Descrição:** Permite que o usuário autenticado altere sua senha, validando a senha atual.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros:
| Parâmetro          | Tipo   | Obrigatório | Descrição                      |
|--------------------|--------|-------------|--------------------------------|
| `current_password` | string | Sim         | A senha atual do usuário.      |
| `new_password`     | string | Sim         | A nova senha do usuário.       |
| `new_password_confirmation` | string | Sim | Confirmação da nova senha.     |

#### Exemplo de Resposta:
```
{
  "message": "Senha alterada com sucesso."
}
```

### Listar Usuários

- **Endpoint:** `/api/user`
- **Método:** `GET`
- **Descrição:** Retorna uma lista de usuários com cargo (funcionário). Apenas administradores (role_id = 2) têm acesso.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Exemplo de Resposta:
```
{
  "data": [
    {
      "id": 1,
      "name": "João Silva",
      "email": "joao.silva@example.com",
      "role": "Funcionário",
	  "address": {
		  "zip_code": "01001-000",
		  "street": "Praça da Sé",
		  "neighborhood": "Sé",
		  "city": "São Paulo",
		  "state": "SP",
		  "complement": "Lado par"
		},
      "created_at": "2024-01-15T08:30:00",
      "updated_at": "2024-01-15T08:30:00"
    },
    {
      "id": 2,
      "name": "Maria Souza",
      "email": "maria.souza@example.com",
      "role": "Funcionário",
	  "address": {
		  "zip_code": "01001-000",
		  "street": "Praça da Sé",
		  "neighborhood": "Sé",
		  "city": "São Paulo",
		  "state": "SP",
		  "complement": "Lado ímpar"
		},
      "created_at": "2024-01-16T08:30:00",
      "updated_at": "2024-01-16T08:30:00"
    }
  ]
}
```
### Criar Usuário

- **Endpoint:** `/api/user`
- **Método:** `POST`
- **Descrição:** Cria um novo usuário com o cargo (funcionário) e endereço especificados. Apenas administradores (role_id = 2) têm acesso.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros:
| Parâmetro     | Tipo   | Obrigatório | Descrição                            |
|---------------|--------|-------------|--------------------------------------|
| `name`        | string | Sim         | Nome do usuário.                     |
| `email`       | string | Sim         | Email do usuário.                    |
| `password`    | string | Sim         | Senha do usuário.                    |
| `password_confirmation` | string | Sim | Confirmação da senha do usuário.     |
| `birthdate`   | date   | Sim         | Data de nascimento do usuário.       |
| `document`    | string | Sim         | CPF do usuário.                      |
| `address`     | object | Sim         | Objeto com os detalhes do endereço.  |

#### Exemplo do Objeto `address`:
| Campo          | Tipo   | Obrigatório | Descrição               |
|----------------|--------|-------------|-------------------------|
| `zip_code`     | string | Sim         | CEP do endereço.        |
| `street`       | string | Sim         | Rua do endereço.        |
| `complement`   | string | Não         | Complemento do endereço.|
| `neighborhood` | string | Sim         | Bairro do endereço.     |
| `city`         | string | Sim         | Cidade do endereço.     |
| `state`        | string | Sim         | Estado do endereço.     |

#### Exemplo de Resposta:
```json
{
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao.silva@example.com",
    "role": "Funcionário",
	"age" => 34
    "address": {
      "zip_code": "01001-000",
      "street": "Praça da Sé",
      "neighborhood": "Sé",
      "city": "São Paulo",
      "state": "SP",
      "complement": "Lado ímpar"
    },
    "created_at": "2024-01-15T08:30:00",
    "updated_at": "2024-01-15T08:30:00"
  }
}
```

### Deletar Usuário

- **Endpoint:** `/api/user/{id}`
- **Método:** `DELETE`
- **Descrição:** Exclui um usuário específico. Apenas administradores (role_id = 2) têm permissão.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros de URL:
| Parâmetro | Tipo   | Obrigatório | Descrição                  |
|-----------|--------|-------------|----------------------------|
| `id`      | int    | Sim         | ID do usuário a ser deletado. |

### Atualizar Usuário

- **Endpoint:** `/api/user/{id}`
- **Método:** `PUT`
- **Descrição:** Atualiza as informações de um usuário específico. Apenas administradores (role_id = 2) têm permissão.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros de URL:
| Parâmetro | Tipo | Obrigatório | Descrição                    |
|-----------|------|-------------|------------------------------|
| `id`      | int  | Sim         | ID do usuário a ser atualizado. |

#### Parâmetros do Corpo da Requisição:
| Parâmetro     | Tipo   | Obrigatório | Descrição                            |
|---------------|--------|-------------|--------------------------------------|
| `name`        | string | Não         | Nome do usuário.                     |
| `email`       | string | Não         | Email do usuário.                    |
| `birthdate`   | date   | Não         | Data de nascimento do usuário.       |
| `document`    | string | Não         | CPF do usuário.                      |
| `address`     | object | Não         | Objeto com os detalhes do endereço.  |

#### Exemplo do Objeto `address`:
| Campo          | Tipo   | Obrigatório | Descrição               |
|----------------|--------|-------------|-------------------------|
| `zip_code`     | string | Não         | CEP do endereço.        |
| `street`       | string | Não         | Rua do endereço.        |
| `complement`   | string | Não         | Complemento do endereço.|
| `neighborhood` | string | Não         | Bairro do endereço.     |
| `city`         | string | Não         | Cidade do endereço.     |
| `state`        | string | Não         | Estado do endereço.     |

#### Exemplo de Resposta:
```
{
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao.silva@example.com",
    "address": {
      "zip_code": "01001-000",
      "street": "Praça da Sé",
      "neighborhood": "Sé",
      "city": "São Paulo",
      "state": "SP",
      "complement": "Lado ímpar"
    },
    "created_at": "2024-01-15T08:30:00",
    "updated_at": "2024-01-15T08:30:00"
  }
}
```

### Exibir Usuário

- **Endpoint:** `/api/user/{id}`
- **Método:** `GET`
- **Descrição:** Exibe os detalhes de um usuário específico. Apenas administradores (role_id = 2) têm permissão.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros de URL:
| Parâmetro | Tipo | Obrigatório | Descrição                  |
|-----------|------|-------------|----------------------------|
| `id`      | int  | Sim         | ID do usuário a ser exibido.|

#### Exemplo de Resposta:
```
{
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao.silva@example.com",
    "role": "Funcionário",
    "birthdate": "1990-05-20",
    "document": "12345678900",
    "address": {
      "zip_code": "01001-000",
      "street": "Praça da Sé",
      "neighborhood": "Sé",
      "city": "São Paulo",
      "state": "SP",
      "complement": "Lado ímpar"
    },
    "created_at": "2024-01-15T08:30:00",
    "updated_at": "2024-01-15T08:30:00"
  }
}
```

### Informações do Usuário Autenticado

- **Endpoint:** `/api/user-info`
- **Método:** `GET`
- **Descrição:** Retorna as informações do usuário atualmente autenticado.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Exemplo de Resposta:
```
{
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao.silva@example.com",
    "role": "Funcionário",
    "birthdate": "1990-05-20",
    "document": "12345678900",
    "address": {
      "zip_code": "01001-000",
      "street": "Praça da Sé",
      "neighborhood": "Sé",
      "city": "São Paulo",
      "state": "SP",
      "complement": "Lado ímpar"
    },
    "created_at": "2024-01-15T08:30:00",
    "updated_at": "2024-01-15T08:30:00"
  }
}
```

### Registrar Ponto

- **Endpoint:** `/api/check-in`
- **Método:** `POST`
- **Descrição:** Cria um novo registro de ponto (check-in ou check-out) para o usuário autenticado.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Exemplo de Resposta:
```
{
  "data": {
    "check_in_id": 123,
    "user": {
		"name": "Funcionario 1",
		"email": "funcionario1@gmail.com"
	},
    "type_name": "check-in",
    "timestamp": "2024-01-15T08:30:00"
  }
}
```

### Listar Registros de Ponto dos Subordinados

- **Endpoint:** `/api/check-in`
- **Método:** `GET`
- **Descrição:** Retorna registros de ponto dos funcionários subordinados do usuário autenticado (apenas administradores).

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros de Query:
| Parâmetro     | Tipo   | Obrigatório | Descrição                    |
|---------------|--------|-------------|------------------------------|
| `start_date`  | date   | Não         | Data de início para filtro.  |
| `end_date`    | date   | Não         | Data de fim para filtro.     |
| `page`        | int    | Não         | Número da página.            |
| `per_page`    | int    | Não         | Registros por página.        |

#### Exemplo de Resposta:
```
{
  "data": [
    {
      "check_in_id": 1,
      "employee_name": "João Silva",
      "role_name": "Funcionário",
      "age": 30,
      "manager_name": "Carlos Pereira",
      "timestamp": "2024-01-15 08:30:00"
    }
  ],
  "current_page": 1,
  "per_page": 15,
  "total_records": 150,
  "total_pages": 10
}
```
### Consultar Registros de Ponto do Dia

- **Endpoint:** `/api/check-in/today`
- **Método:** `GET`
- **Descrição:** Retorna os registros de ponto do dia atual para o usuário autenticado.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Exemplo de Resposta:
```
{
  "data": [
  	{
		"check_in_id": 123,
		"user": {
			"name": "Funcionario 1",
			"email": "funcionario1@gmail.com"
		},
		"type_name": "check-in",
		"timestamp": "2024-01-15T08:30:00"
	  }
	  {
		"check_in_id": 124,
		"user": {
			"name": "Funcionario 1",
			"email": "funcionario1@gmail.com"
		},
		"type_name": "check-out",
		"timestamp": "2024-01-15T11:30:00"
	  }
  ]
}
```
### Buscar Endereço por CEP

- **Endpoint:** `/api/address/{zipCode}`
- **Método:** `GET`
- **Descrição:** Busca os detalhes de endereço através de um CEP usando a API ViaCEP.

#### Headers:
| Cabeçalho       | Valor            |
|-----------------|------------------|
| `Authorization` | Bearer {token}   |

#### Parâmetros de URL:
| Parâmetro | Tipo   | Obrigatório | Descrição                   |
|-----------|--------|-------------|-----------------------------|
| `zipCode`     | string | Sim         | CEP do endereço a ser buscado. |

#### Exemplo de Resposta:
```
{
  "data": {
    "cep": "01001-000",
    "logradouro": "Praça da Sé",
    "bairro": "Sé",
    "localidade": "São Paulo",
    "uf": "SP",
    "complemento": "Lado ímpar"
  }
}
```

### Health Check

- **Endpoint:** `/api/health-check`
- **Método:** `GET`
- **Descrição:** Verifica o status da API para garantir que está funcionando corretamente.

#### Exemplo de Resposta:
```
{
    "status": "health"
}
```
