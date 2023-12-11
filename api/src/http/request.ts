import axios, {AxiosResponse, AxiosStatic} from "axios";
import {BaseResponse} from "./response";


export class BaseRequest {
    private _headers: Record<string, string>;
    private _absoluteUrl: string;

    public static POST: 'POST' = 'POST';
    public static GET: 'GET' = 'GET';
    public static PUT: 'PUT' = 'PUT';
    public static DELETE: 'DELETE' = 'DELETE';
    public static PATCH: 'PATCH' = 'PATCH';

    constructor(absoluteUrl?: string, headers?: Record<string, string>) {
        if (!absoluteUrl) {
            absoluteUrl = 'http://app/api/';
        }

        if (!headers) {
            headers = {'Content-Type': 'application/json'};
        }
        this.absoluteUrl = absoluteUrl;
        this.headers = headers;
    }

    public async sendRequest(
        method: string,
        url: string,
        params?:
            | {name: string, color: string, score: number, type: string}
            | {uuid: string,  color: string}
            | {startDate: string, endDate: string, type: string},
    ): Promise<BaseResponse> {
        try {
            const sendUrl = `${this.absoluteUrl}${url}`;
            const sendHeaders = this.headers;

            const res: AxiosResponse = await this.getSender()({
                method,
                url: sendUrl,
                headers: sendHeaders,
                data: params,
            });

            return new BaseResponse({body: res.data, success: res.status === 200});
        } catch (error) {
            return new BaseResponse({ body: {error: error.response.data.detail}, success: false });
        }
    }

    set absoluteUrl(url: string) {
        this._absoluteUrl = url;
    }

    get absoluteUrl(): string {
        return this._absoluteUrl;
    }

    set headers(headers: Record<string, string>) {
        this._headers = headers;
    }

    get headers(): Record<string, string> {
        return this._headers;
    }

    protected getSender(): AxiosStatic {
        return axios
    }
}

export const baseRequest: BaseRequest = new BaseRequest();