import { DeleteResult, UpdateResult } from "typeorm";
import { BaseService } from "../config/base.service";
import { TaskDTO } from "../task/DTOs/task.dto";
import { TaskEntity } from "../task/entities/task.entity";


export class TaskService extends BaseService<TaskEntity> {
  constructor() {
    super(TaskEntity);
  }

  async findAllTaskts(): Promise<TaskEntity[]> {
    return (await this.execRepository).find();
  }
  async findTasktById(id: string): Promise<TaskEntity | null> {
    return (await this.execRepository).findOneBy({ id });
  }
  async createTask(body: TaskDTO): Promise<TaskEntity> {
    return (await this.execRepository).save(body);
  }
  async deleteTask(id: string): Promise<DeleteResult> {
    return (await this.execRepository).delete({ id });
  }
  async updateTask(
    id: string,
    infoUpdate: TaskDTO
  ): Promise<UpdateResult> {
    return (await this.execRepository).update(id, infoUpdate);
  }
}