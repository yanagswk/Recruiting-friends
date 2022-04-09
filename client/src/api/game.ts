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
    comment: comment,
    psid: ps_id,
    steamid: steam_id,
    originid: origin_id,
    skypeid: skype_id,
    discordid: discord_id,
    friend_code: friend_code_id,
  });
};
