
import { BaseRoutres } from "../shared/routes/router";
import { PriorityController } from "./controllers/priority.controller"
import { PriorityMiddleware } from "./middlewares/priority.middleware";

export class PriorityRouter extends BaseRoutres<PriorityController, PriorityMiddleware> {
    constructor() {
        super(PriorityController, PriorityMiddleware);
    }

    routes(): void {
        this.router.get("/priority", (req, res) => this.controller.getPriorities(req, res));
        this.router.get("/priority/:id", (req, res) =>
            this.controller.getPriorityById(req, res)
        );
        this.router.post("/createPriority", (req, res, next) => [this.middelware.priorityValidator(req, res, next)], (req, res) =>
            this.controller.createPriority(req, res)
        );
        this.router.put("/updatePriority/:id", (req, res) =>
            this.controller.updatePriority(req, res)
        );
        this.router.delete("/deletePriority/:id", (req, res) =>
            this.controller.deletePriority(req, res)
        );
    }
}