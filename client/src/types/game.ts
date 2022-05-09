export interface GameList {
  id: number;
  game_name: string;
  game_image_url?: string;
  hardware_list: string[];
}

export interface RecruitmentPage {
  game_id: number;
  game_name: string;
  game_image_url: string;
  hardware_id: number;
  hardware_name: string;
  hardwares: Array<{
    hardware_id: number;
    hardware_name: string;
  }>;
  purpose_list: Array<{
    purpose_id: number;
    purpose_name: string;
  }>;
  comment: string;
  ps_id: string;
  select_hardware_id: number;
  select_purpose_id: number;
}

// TODO: Hardware.Friend被り　拡張interface作る
export interface Hardware {
  hardware_id: number;
  hardware_name: string;
}
export interface Friend {
  hardware_id: number;
  hardware_name: string;
}
export interface PurposeList {
  purpose_id: number;
  purpose_name: string;
}
export interface RecruitmentList {
  id: number;
  game_id: number;
  hardware_id: number;
  hardware_name: string;
  comment: number;
  created_at: string;
  friend_name_list: {
    hardware_friend_id: number;
    friend_id_name: string;
    friend_name: string;
  }[];
}
export interface FriendIdList {
  [key: number]: {
    [key: number]: string;
  }[];
}
