// import { AxiosPromise } from "axios";
import axios from "@/https";

/**
 * ゲーム一覧取得
 */
export const getGameList = (): any => {
  return axios.get("api/game_list");
};
/**
 * ゲーム取得
 * @param game_id number ゲームid
 * @param page number 何ページ目か
 * @param hardware_id number 表示するハードウェアid
 */
export const getGame = (
  game_id: number,
  page: number,
  hardware_id?: number
): any => {
  return axios.get("api/game", {
    params: {
      game_id: game_id,
      page: page,
      hardware_id: hardware_id,
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
/**
 * 追加したいゲームのリクエスト
 */
export const postRequestAddGameMail = (
  game_name: string,
  hardware_id_list?: number[],
  user_message?: string
) => {
  return axios.post("api/request_add_game_mail", {
    game_name: game_name,
    hardware_id_list: hardware_id_list,
    user_message: user_message,
  });
};
