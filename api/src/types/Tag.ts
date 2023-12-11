import {Field, InputType} from "type-graphql";
import {IsDateString, IsEnum, IsPositive, IsUUID, Length} from "class-validator";

enum TagType {
    FIRST = 'FIRST',
    SECOND = 'SECOND'
}

@InputType()
export class UpdateTagInput {

    @Field()
    @IsUUID()
    uuid: string

    @Field()
    @Length(3, 255)
    color: string
}

@InputType()
export class CreateTagInput {

    @Field()
    @Length(3, 255)
    color: string

    @Field()
    @Length(3, 255)
    name: string

    @Field()
    @IsEnum(TagType)
    type: string

    @Field()
    @IsPositive()
    score: number
}

@InputType()
export class GetStatsInput {

    @Field()
    @IsDateString()
    startDate: string

    @Field()
    @IsDateString()
    endDate: string

    @Field()
    @IsEnum(TagType)
    type: string
}