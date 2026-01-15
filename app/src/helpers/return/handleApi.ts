export function returnResApi(success: boolean, message: string, data: any): ReturnResApi {
    return {
        success: success,
        message: message,
        data: data
    };
};