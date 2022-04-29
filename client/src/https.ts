// https://qiita.com/Esfahan/items/1b41b64d0a605732a0dd
import axios, { AxiosInstance } from "axios";
// import { useStore } from "@/store/index";  // vueファイルではない場合にVuexをimportする場合はuseStoreではなくstoreをimport
import { store } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { ERR } from "@/store/common";

// const store = useStore();

const apiClient: AxiosInstance = axios.create({
  // APIのURI
  baseURL: "http://localhost:80",
  // リクエストヘッダ
  headers: {
    "Content-type": "application/json",
  },
  timeout: 5000,
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
    return response.data;
  },
  (error) => {
    console.log(error.response || error);
    store.commit(MutationTypes.ERR_FLASH_MSG, ERR);
    if (store.state.is_loading) {
      store.commit(MutationTypes.IS_LOADING, false);
    }
    switch (error.response.status) {
      case 404:
        return Promise.reject(error);
      case 422:
        // バリデーションエラー
        return Promise.reject(error);
      default:
        return Promise.reject(error);
    }
  }
); // エラーで認証(ログイン)してるかを見る

export default apiClient;
