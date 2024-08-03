import * as dotenv from "dotenv"
import { DataSource } from "typeorm";
import { AppDataSource } from "./data.source";

export abstract class ConfigServer {
    constructor() {
        const nodeNameEnv = this.createPathEnv(this.nodeEnv);
        dotenv.config({
            path: nodeNameEnv,
        });
    }

    public getEnviroment(k: string) {
        return process.env[k];
    }

    public getNumberEnv(k: string): number {
        return Number(this.getEnviroment(k));
    }

    public get nodeEnv(): string {
        return this.getEnviroment("NODE_ENV")?.trim() || "";
    }

    public createPathEnv(path: string): string {
        const arrayEnv: Array<string> = ['env'];
        if (path.length > 0) {
            const stringToArry = path.split('.');
            arrayEnv.unshift(...stringToArry);
        }
        return '.' + arrayEnv.join('.');
    }

    // DB_HOST= localhost
    // DB_PORTS = 3312
    // DB_MYSQL_DATABASE= terrafactora
    // DB_MYSQL_ROOT_USER= root
    // DB_MYSQL_USER= terra_user
    // DB_MYSQL_ROOT_PASSWORD= secret
    // DB_MYSQL_PASSWORD= secret

    get initConnect(): Promise<DataSource> {
        return AppDataSource.initialize();
    }

}