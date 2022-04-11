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

// api送信時
apiClient.interceptors.request.use(
  (config) => {
    console.log(config);
    return config;
  },
  (error) => {
    console.error("error:", error);
    return Promise.reject(error);
  }
);

// api返却時
apiClient.interceptors.response.use(
  // 成功時レスポンス
  (response) => {
    console.log(response);
    return response.data;
  },
  (error) => {
    console.log(error.response || error);
    switch (error.response.status) {
      case 404:
        return Promise.reject(error);
      case 422:
        // バリデーションエラー
        // TODO: アラートコンポーネント処理
        // return error.response;
        return Promise.reject(error);
      default:
        return Promise.reject(error);
    }
  }
); // エラーで認証(ログイン)してるかを見る

export default apiClient;
