import { Router } from "express";

export class BaseRoutres<T, U>{
    public router: Router;
    public controller: T;
    public middelware: U;
    constructor(Tcontroller: { new(): T }, UMiddleware: { new(): U }) {
        this.router = Router();
        this.controller = new Tcontroller();
        this.middelware = new UMiddleware();
        this.routes();

    }

    routes() { }
}