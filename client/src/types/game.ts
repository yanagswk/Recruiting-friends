export interface GameList {
  id: number;
  game_name: string;
  game_image_url?: string;
  hardware_id: number;
  created_at?: string;
  updated_at?: string;
  hardware_name: string;
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

export interface Hardware {
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
  ps_id: string;
  steam_id: string;
  origin_id: string;
  skype_id: string;
  discord_id: string;
  friend_code_id: string;
  created_at: string;
}