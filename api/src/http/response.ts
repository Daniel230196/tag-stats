export interface IBaseResponse {
    success: boolean,
    body: ResponseBody
}

export type ResponseBody = {
    [Key: string]: any
};


export class BaseResponse {
    private _response: IBaseResponse;
    private _body : ResponseBody;
    private _status: boolean;
    constructor(response: IBaseResponse) {
        this._response = response;
        this.parseResponse();
    }

    get response(): IBaseResponse {
        return this._response;
    }

    set response(value: IBaseResponse) {
        this._response = value;
    }

    get body(): ResponseBody {
        return this._body;
    }

    set body(value: ResponseBody) {
        this._body = value;
    }


    get status(): boolean {
        return this._status;
    }

    set status(value: boolean) {
        this._status = value;
    }
    public parseResponse(): void {
        this.status = this.response.success;
        this.body = this.response.body;
    }
}
