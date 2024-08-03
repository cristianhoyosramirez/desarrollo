import { DeleteResult, UpdateResult } from "typeorm";
import { BaseService } from "../config/base.service";
import { StatusDTO } from "../status/DTOs/status.dto";
import { StatusEntity } from "../status/entities/status.entity";


export class StatusService extends BaseService<StatusEntity> {
  constructor() {
    super(StatusEntity);
  }

  async findAllStatus(): Promise<StatusEntity[]> {
    return (await this.execRepository).find();
  }
  async findStatusById(id: string): Promise<StatusEntity | null> {
    return (await this.execRepository).findOneBy({ id });
  }
  async createStatus(body: StatusDTO): Promise<StatusEntity> {
    return (await this.execRepository).save(body);
  }
  async deleteStatus(id: string): Promise<DeleteResult> {
    return (await this.execRepository).delete({ id });
  }
  async updateStatus(
    id: string,
    infoUpdate: StatusDTO
  ): Promise<UpdateResult> {
    return (await this.execRepository).update(id, infoUpdate);
  }
}