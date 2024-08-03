import { DeleteResult, UpdateResult } from "typeorm";
import { BaseService } from "../config/base.service";
import { PriorityDTO } from "../priority/DTOs/priority.dto";
import { PriorityEntity } from "../priority/entities/priority.entity";


export class PriorityService extends BaseService<PriorityEntity> {
  constructor() {
    super(PriorityEntity);
  }

  async findAllpriorities(): Promise<PriorityEntity[]> {
    return (await this.execRepository).find();
  }
  async findpriorityById(id: string): Promise<PriorityEntity | null> {
    return (await this.execRepository).findOneBy({ id });
  }
  async createpriority(body: PriorityDTO): Promise<PriorityEntity> {
    return (await this.execRepository).save(body);
  }
  async deletepriority(id: string): Promise<DeleteResult> {
    return (await this.execRepository).delete({ id });
  }
  async updatepriority(
    id: string,
    infoUpdate: PriorityDTO
  ): Promise<UpdateResult> {
    return (await this.execRepository).update(id, infoUpdate);
  }
}