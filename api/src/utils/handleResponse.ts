// here we creating common response
// instead of several single responses
import {BaseResponse, ResponseBody} from "../http/response";

export default function handleResponse(
    response: BaseResponse,
): BaseResponse {
    const body: ResponseBody = {};

    for (const key in response.body) {
        // @ts-ignore
        const k = response.body[key];

        if (!body[key]) {
            body[key] = k;
        } else {
            body[`${key}_1`] = k;
        }
    }

    return new BaseResponse({
        success: response.status,
        body: body,
    });
}
