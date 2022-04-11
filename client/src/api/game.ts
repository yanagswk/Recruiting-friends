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
/**
 * フレンドを募集する
 */
export const postRecruitment = (
  game_id: number,
  hardware_id: number,
  comment: string,
  ps_id?: string,
  steam_id?: string,
  origin_id?: string,
  skype_id?: string,
  discord_id?: string,
  friend_code_id?: string
) => {
  return axios.post("api/recruitment", {
    game_id: game_id,
    hardware_id: hardware_id,
    comment: comment,
    ps_id: ps_id,
    steam_id: steam_id,
    origin_id: origin_id,
    skype_id: skype_id,
    discord_id: discord_id,
    friend_code_id: friend_code_id,
  });
};
