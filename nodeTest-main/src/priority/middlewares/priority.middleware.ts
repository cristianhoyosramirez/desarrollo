import { validate } from "class-validator";
import { NextFunction, Request, Response } from "express";

import { HttpResponse } from "../../shared/response/http.response";
import { PriorityDTO } from "../DTOs/priority.dto";


export class PriorityMiddleware {
    constructor(
        private readonly httpResponse: HttpResponse = new HttpResponse()
    ) { }
    priorityValidator(req: Request, res: Response, next: NextFunction) {
        const { name, desc } = req.body;

        const valid: PriorityDTO = new PriorityDTO();
        valid.name = name;
        valid.desc = desc;

        validate(valid).then((err) => {
            if (err.length > 0) {
                return this.httpResponse.Error(res, err);
            } else {
                next();
            }
        });
    }
}