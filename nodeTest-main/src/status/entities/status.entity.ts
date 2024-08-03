
import { Column, Entity, OneToMany, OneToOne, PrimaryGeneratedColumn } from "typeorm";
import { BaseEntity } from "../../config/base.entity";
import { TaskEntity } from "../../task/entities/task.entity";


@Entity({ name: "status" })
export class StatusEntity extends BaseEntity {

    @Column()
    name!: string;

    @Column()
    desc!: string;

    @OneToMany(() => TaskEntity, task => task.statusTask)
    statusTask?: TaskEntity[];


}