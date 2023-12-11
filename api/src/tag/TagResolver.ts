import "reflect-metadata";
import {Arg, Mutation, Query, Resolver} from "type-graphql";
import {BaseRequest} from '../http/request';
import {baseRequest} from "../http/request";
import Response from "../types/Response";
import handleResponse from "../utils/handleResponse";
import {BaseResponse} from "../http/response";
import {CreateTagInput, GetStatsInput, UpdateTagInput} from "../types/Tag";

@Resolver()
export class TagResolver {
    @Mutation(() => Response)
    async updateTag(
        @Arg('updateTagInput') updateTagInput: UpdateTagInput
    ): Promise<BaseResponse> {
        try {
            const response = await baseRequest.sendRequest(
                BaseRequest.PATCH,
                'tag',
                {uuid: updateTagInput.uuid, color: updateTagInput.color}
            );

            return handleResponse(response);
        } catch (err) {
            return handleResponse(err);
        }
    }

    @Mutation(() => Response)
    async createTag(
        @Arg('createTagInput') createTagInput: CreateTagInput
    ): Promise<BaseResponse> {
        try {
            const response = await baseRequest.sendRequest(
                BaseRequest.POST,
                'tag',
                {
                    color: createTagInput.color,
                    name: createTagInput.name,
                    type: createTagInput.type,
                    score: createTagInput.score,
                }
            );

            return handleResponse(response);
        } catch (err) {
            return handleResponse(err)
        }
    }

    @Query(() => Response)
    async getTagsStat(
        @Arg('getStatsInput') getStatsInput: GetStatsInput
    ): Promise<BaseResponse> {
        try {
            console.log( getStatsInput.startDate, getStatsInput.endDate, getStatsInput.type)
            const startDate = encodeURIComponent(getStatsInput.startDate);
            const endDate = encodeURIComponent(getStatsInput.endDate);
            const response = await baseRequest.sendRequest(
                BaseRequest.GET,
                `tag-stats?startDate=${startDate}&endDate=${endDate}&type=${getStatsInput.type}`
            );

            return handleResponse(response);
        } catch (err) {
            return handleResponse(err);
        }

    }
}