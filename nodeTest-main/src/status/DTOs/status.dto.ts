import { IsNotEmpty } from "class-validator";
import { BaseDTO } from "../../config/base.dto";
import { StatusEntity } from "../entities/status.entity";


export class StatusDTO extends BaseDTO {
    @IsNotEmpty()
    name!: string;

    @IsNotEmpty()
    desc!: string;


    task?: StatusEntity[];
}