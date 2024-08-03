import { Request, Response } from "express";
import { PriorityService } from "../../services/priority.service";


export class PriorityController {
  constructor(
    private readonly priorityService: PriorityService = new PriorityService()
  ) {}
  async getPriorities(req: Request, res: Response) {
    try {
      const data = await this.priorityService.findAllpriorities();
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async getPriorityById(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.priorityService.findpriorityById(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async createPriority(req: Request, res: Response) {
    try {
      const data = await this.priorityService.createpriority(req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async updatePriority(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.priorityService.updatepriority(id, req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async deletePriority(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.priorityService.deletepriority(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
}