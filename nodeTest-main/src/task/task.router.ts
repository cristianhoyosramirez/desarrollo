import { BaseRoutres } from "../shared/routes/router";
import { TaskController } from "./controllers/tasks.controller"
import { TaskMiddleware } from "./middlewares/task.middleware";

export class TaskRouter extends BaseRoutres<TaskController,TaskMiddleware> {
    constructor() {
        super(TaskController,TaskMiddleware);
    }

    routes(): void {
        this.router.get("/task", (req, res) => this.controller.getTasks(req, res));
        this.router.get("/task/:id", (req, res) =>
            this.controller.getTaskById(req, res)
        );
        this.router.post("/createTask",(req, res, next) => [this.middelware.taskValidator(req, res, next)] ,(req, res) =>
            this.controller.createTask(req, res)
        );
        this.router.put("/updateTask/:id", (req, res) =>
            this.controller.updateTask(req, res)
        );
        this.router.delete("/deleteTask/:id", (req, res) =>
            this.controller.deleteTask(req, res)
        );
    }
}