// import { AxiosPromise } from "axios";
import axios from "@/https";

/**
 * ゲーム一覧取得
 */
export const getGameList = () => {
  return axios.get("api/game_list");
};
/**
 * ゲーム取得
 */
export const getGame = (game_id: number) => {
  return axios.get("api/game", {
    params: {
      game_id: game_id,
    },
  });
};
