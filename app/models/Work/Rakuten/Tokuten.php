<?php
/**
 * @author admin-97
 */
class WorkRakutenTokuten extends Eloquent  {
    const TYPE_TOKUTEN_1 = 1;
    const TYPE_TOKUTEN_2 = 2;
    
    public static function convertTokuten()
    {
        foreach(self::all() as $wTokuten) {
            $tokuten = Tokuten::where('privilege_no','=',$wTokuten->privilege_no)->first();
            if(!$tokuten) {
                $tokuten = new Tokuten();
            }
            $tokuten->type = $wTokuten->type;
            $tokuten->type_no = $wTokuten->type_no;
            $tokuten->privilege_no = $wTokuten->privilege_no;
            $tokuten->privilege_name = $wTokuten->privilege_name;
            $tokuten->privilege_content = $wTokuten->privilege_content;
            $tokuten->privilege_object = $wTokuten->privilege_object;
            $tokuten->application_method = $wTokuten->application_method;
            $tokuten->fd_span_from= $wTokuten->fd_span_from;
            $tokuten->fd_span_to = $wTokuten->fd_span_to;
            $tokuten->access_view= $wTokuten->access_view;
            $tokuten->save();
        }
    }
}
