/**
 * セッションストレージにセット
 * @param name
 * @param content
 * @returns
 */
export const setSessionStore = (name: string, content: string | string[]) => {
  if (!name) return;
  if (typeof content !== "string") {
    content = JSON.stringify(content);
  }
  sessionStorage.setItem(name, content);
};
/**
 * セッションストレージから取得
 * @param name
 * @returns
 */
export const getSessionStore = (name: string) => {
  if (!name) return;
  return sessionStorage.getItem(name);
};
/**
 * セッションストレージから削除
 * @param name
 * @returns
 */
export const removeSessionStore = (name: string) => {
  if (!name) return;
  sessionStorage.removeItem(name);
};
