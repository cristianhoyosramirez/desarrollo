import { validate } from "class-validator";
import { NextFunction, Request, Response } from "express";

import { HttpResponse } from "../../shared/response/http.response";
import { StatusDTO } from "../DTOs/status.dto";


export class StatusMiddleware {
    constructor(
        private readonly httpResponse: HttpResponse = new HttpResponse()
    ) { }
   statusValidator(req: Request, res: Response, next: NextFunction) {
        const { name, desc, task } = req.body;

        const valid: StatusDTO = new StatusDTO();
        valid.name = name;
        valid.desc = desc;
        valid.task= task;

        validate(valid).then((err) => {
            if (err.length > 0) {
                return this.httpResponse.Error(res, err);
            } else {
                next();
            }
        });
    }
}