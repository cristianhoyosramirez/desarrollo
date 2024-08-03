
import { Column, Entity, JoinColumn, ManyToOne } from "typeorm";
import { BaseEntity } from "../../config/base.entity";
import { PriorityEntity } from "../../priority/entities/priority.entity";
import { StatusEntity } from "../../status/entities/status.entity";

@Entity({ name: "task" })
export class TaskEntity extends BaseEntity {

    @Column()
    name!: string;

    @Column()
    desc!: string;

    @Column({ nullable: true })
    beginDate!: Date;

    @Column({ nullable: true })
    endDate!: Date;

    @Column({ nullable: true })
    taskFather!: string;

    @ManyToOne(() => PriorityEntity, Priority => Priority.priorityTask)
    @JoinColumn({ name: "priority_id" })
    priorityTask!: PriorityEntity;


    @ManyToOne(() => StatusEntity, status => status.statusTask)
    @JoinColumn({ name: "status_id" })
    statusTask!: StatusEntity;
}