import { Request, Response } from "express";
import { StatusService } from "../../services/status.service";
import { TaskService } from "../../services/task.service";


export class TaskController {
  constructor(
    private readonly taskService: TaskService = new TaskService()
  ) {}
  async getTasks(req: Request, res: Response) {
    try {
      const data = await this.taskService.findAllTaskts();
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async getTaskById(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.taskService.findTasktById(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async createTask(req: Request, res: Response) {
    try {
      const data = await this.taskService.createTask(req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async updateTask(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.taskService.updateTask(id, req.body);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
  async deleteTask(req: Request, res: Response) {
    const { id } = req.params;
    try {
      const data = await this.taskService.deleteTask(id);
      res.status(200).json(data);
    } catch (e) {
      console.error(e);
    }
  }
}