import { validate } from "class-validator";
import { NextFunction, Request, Response } from "express";

import { HttpResponse } from "../../shared/response/http.response";
import { TaskDTO } from "../DTOs/task.dto";

export class TaskMiddleware {
    constructor(
        private readonly httpResponse: HttpResponse = new HttpResponse()
    ) { }
    taskValidator(req: Request, res: Response, next: NextFunction) {
        const { name, desc, beginDate, endDate, taskFather, priority, status } = req.body;

        const valid: TaskDTO = new TaskDTO();
        valid.name = name;
        valid.desc = desc;
        valid.beginDate = beginDate;
        valid.endDate = endDate;
        valid.taskFather = taskFather;
        valid.priority = priority;
        valid.status = status;


        validate(valid).then((err) => {
            if (err.length > 0) {
                return this.httpResponse.Error(res, err);
            } else {
                next();
            }
        });
    }
}