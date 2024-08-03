
import { Column, Entity, JoinColumn, OneToMany, OneToOne, PrimaryGeneratedColumn } from "typeorm";
import { BaseEntity } from "../../config/base.entity";
import { TaskEntity } from "../../task/entities/task.entity";


@Entity({ name: "priority" })
export class PriorityEntity extends BaseEntity {

    @Column()
    name!: string;

    @Column()
    desc!: string;

    @OneToMany(() => TaskEntity, task => task.priorityTask)
    priorityTask?: TaskEntity[];



}