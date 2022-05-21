export const SUCCESS_MSG = "送信が成功しました。";

export const GAME_NAME_ERR = "ゲーム名は必須です。";

export const COMMENT_ERR = "コメントは必須です。";

export const INQUIRY_ERR = "タイトルとお問い合わせ内容は必須です。";

export const ERR = "エラーが起きました。";

export const CONFIRM = "送信しますか？";

export const hardwareBcColor = {
  1: "bg-blue-500", // PS4
  2: "bg-indigo-600", // PS5
  4: "bg-red-500", // Swich
  5: "bg-green-500", // XboxOne
  6: "bg-yellow-500", // PC
};
export type ColorBcNumber = keyof typeof hardwareBcColor;

export const hardwareTextColor = {
  1: "text-blue-500", // PS4
  2: "text-indigo-600", // PS5
  4: "text-red-500", // Swich
  5: "text-green-500", // XboxOne
  6: "text-yellow-500", // PC
};
export type ColorTextNumber = keyof typeof hardwareTextColor;

export const FRIENDID = {
  PSID: 1,
  ORIGINID: 2,
  SKYPEID: 3,
  DISCORDID: 4,
  STEAMID: 5,
  FRIENDCODE: 6,
};
