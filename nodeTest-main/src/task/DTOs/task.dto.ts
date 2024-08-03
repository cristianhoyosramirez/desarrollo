import { IsNotEmpty } from "class-validator";
import { BaseDTO } from "../../config/base.dto";
import { PriorityEntity } from "../../priority/entities/priority.entity";
import { StatusEntity } from "../../status/entities/status.entity";



export class TaskDTO extends BaseDTO {

    @IsNotEmpty()
    name!: string;

    @IsNotEmpty()
    desc!: string;


    beginDate!: Date;


    endDate!: Date;

    taskFather!: string;


    priority!: PriorityEntity;


    status!: StatusEntity;
}