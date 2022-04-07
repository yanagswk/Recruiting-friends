// import { AxiosPromise } from "axios";
import axios from "@/https";

/**
 * ゲーム一覧取得
 */
export const getGameList = () => {
  return axios.get("api/game_list");
};
