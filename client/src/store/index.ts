import { InjectionKey } from "vue";
import { createStore, Store, useStore as baseUseStore } from "vuex";
import * as MutationTypes from "./mutationType";

// stateの型定義
interface State {
  is_loading: boolean;
  // message?: string;
}

// storeをprovide/injectするためのキー
export const key: InjectionKey<Store<State>> = Symbol();

// store本体
export const store = createStore<State>({
  state: {
    is_loading: false,
    // message: "",
  },
  mutations: {
    [MutationTypes.IS_LOADING](state, is_loading: boolean) {
      state.is_loading = is_loading;
    },
    // [MutationTypes.IS_LOADING](state, loading: State) {
    //   state.is_loading = loading.is_loading;
    //   state.message = loading.message ?? "";
    // },
  },
});

// useStoreを使う時にキーの指定を省略するためのラッパー関数
export const useStore = () => {
  return baseUseStore(key);
};
