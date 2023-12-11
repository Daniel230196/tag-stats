import {GraphQLScalarType} from "graphql";
import {IBaseResponse} from "../http/response";

export default new GraphQLScalarType({
        name: "JsonResponse",
        description: "Response",
        serialize: (value: { response: IBaseResponse }) => {
            const {
                body,
                success,
            } = value.response;

            return {
                body,
                success,
            }
        }
    }
);