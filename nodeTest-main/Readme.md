
# Terrafactora instalation

para la instalacion del proyecto nesesitaremos los siguientes programas 
- docker
- node js  

comandos de instalacion

primero creamos la imagen con el siguiente comando 
- docker build --no-cache --progress=plain  -t api-node-ts . 

El siguiente comnado es para ejecutar la base de datos de mysql y ejecucion del proyecto

- docker-compose up



cons estos comando puedes probar en postman las siguientes urls que hacen referncia a los modulos 

Status


    - get: http://localhost:8000/api/status

        
    - get: http://localhost:8000/api/status/80d0b9df-abe5-4331-a99b-30e55e89108f
        get by id

    - post:  http://localhost:8000/api/createStatus
     el body debe ser  en esta forma 
     {
        "name":"moderado",
        "desc": "moderado"
     }
     
     
    - put:  http://localhost:8000/api/updateStatus/80d0b9df-abe5-4331-a99b-30e55e89108f
     el body debe ser  en esta forma 
     {
        "name":"moderado",
        "desc": "moderado"
     }

      - delete:  http://localhost:8000/api/deleteStatus/80d0b9df-abe5-4331-a99b-30e55e89108f

priority

    - get: http://localhost:8000/api/priority

    - get http://localhost:8000/api/priority/80d0b9df-abe5-4331-a99b-30e55e89108f
        get by id

    - post:  http://localhost:8000/api/createPriority
     el body debe ser  en esta forma 
     {
        "name":"moderado",
        "desc": "moderado"
     }
     
     
    - put:  http://localhost:8000/api/updatePriority/80d0b9df-abe5-4331-a99b-30e55e89108f
     el body debe ser  en esta forma 
     {
        "name":"moderado",
        "desc": "moderado"
     }

      - delete: http://localhost:8000/api/deletePriority/80d0b9df-abe5-4331-a99b-30e55e89108f

task

    - get: http://localhost:8000/api/task

    - post:  http://localhost:8000/api/createTask
     el body debe ser  en esta forma 
        {
        "name":"peuba task",
        "desc": "prueba task",
        "beginDate":"",
        "endDate":"",
        "taskFather":"",
        "priorityTask":{"id":"a0345d5e-e315-44b3-baf5-ee4001ffabff"},
        "statusTask":{"id":"17c7ed61-42f7-40cc-a07d-1b31571b765f"}
        }
        
     
    - put:  http://localhost:8000/api/updateTask/80d0b9df-abe5-4331-a99b-30e55e89108f
     el body debe ser  en esta forma 
       {
        "name":"peuba task",
        "desc": "prueba task",
        "beginDate":"",
        "endDate":"",
        "taskFather":"",
        "priorityTask":{"id":"a0345d5e-e315-44b3-baf5-ee4001ffabff"},
        "statusTask":{"id":"17c7ed61-42f7-40cc-a07d-1b31571b765f"}
        }


      - delete: http://localhost:8000/api/deleteTask/80d0b9df-abe5-4331-a99b-30e55e89108f

    Modelo relacional

    ![Image text](assets/Diagrama%20entidad%20relacion.PNG)