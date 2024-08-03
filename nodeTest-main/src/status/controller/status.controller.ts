import { Request, Response } from "express";
import { StatusService } from "../../services/status.service";


export class StatusController {
  constructor(
    private readonly statusService: StatusService = new StatusService()
  ) {}
  async getStatus(req: Request, res: Response) {
    try {
      const data = await this.statusService.findAllStatus();
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async getStatusById(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.statusService.findStatusById(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async createStatus(req: Request, res: Response) {
    try {
      const data = await this.statusService.createStatus(req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async updateStatus(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.statusService.updateStatus(id, req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async deleteStatus(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.statusService.deleteStatus(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
}