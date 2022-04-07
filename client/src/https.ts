// https://qiita.com/Esfahan/items/1b41b64d0a605732a0dd
import axios, { AxiosInstance } from "axios";

const apiClient: AxiosInstance = axios.create({
  // APIのURI
  baseURL: "http://localhost:80",
  // リクエストヘッダ
  headers: {
    "Content-type": "application/json",
  },
});

apiClient.interceptors.response.use(
  (response) => response, // 成功時レスポンス
  // (error) => error.response || error // https://github.com/ynzy/vue3-h5-template/blob/main/src/utils/request.ts
  (error) => {
    console.log(error);
    return error.response || error;
  }
); // エラーで認証(ログイン)してるかを見る

export default apiClient;
