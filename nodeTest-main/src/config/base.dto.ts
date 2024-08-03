import { IsDate, IsOptional, IsUUID } from "class-validator";

export class BaseDTO {
  @IsUUID()
  @IsOptional()
  id!: string;

}