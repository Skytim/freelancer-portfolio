package com.erp.dto;

public class ApiResponse<T> {
    private boolean success;
    private String message;
    private T data;

    public ApiResponse(boolean success, String message, T data) {
        this.success = success; this.message = message; this.data = data;
    }

    public boolean isSuccess() { return success; }
    public void setSuccess(boolean s) { this.success = s; }
    public String getMessage() { return message; }
    public void setMessage(String m) { this.message = m; }
    public T getData() { return data; }
    public void setData(T d) { this.data = d; }

    public static <T> ApiResponse<T> ok(T data) {
        return new ApiResponse<T>(true, "OK", data);
    }

    public static <T> ApiResponse<T> fail(String msg) {
        return new ApiResponse<T>(false, msg, null);
    }
}
