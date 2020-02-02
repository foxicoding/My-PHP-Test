#!/bin/bash
log2kafka="/mfw_data/log/share"
log_backup="/mfw_data/log_backup_docker"
kafka_brokers="${1}"
log_source="server_event page_event mobile_event monitor_event weapp_event"

c_min=`date +%Y%m%d%H%M`
l_min=`date -d "-1 minutes" +%Y%m%d%H%M`
l_day=`echo ${l_min:0:8}`

function fileTail() {

     tail_file=$1
     source=$2
     c_sec=`date +%S`
     while [ ! -f "$tail_file" ]
     do
         if [[ $c_sec -gt 60 ]];then
                 return
         fi
         let c_sec=c_sec+1
         sleep 1
     done
     tail -n +1 -f $tail_file|php logPipeLine.php ${source}
}

#tail log to kafka
function tail2Kafka() {
    for source in  $log_source
    do
       c_file="$log2kafka/$source/$source.$c_min"
       fileTail $c_file $source &
    done
}
#stop tail2kafka
function stopTail2Kafka(){
    for source in $log_source
    do

        l_file="$log2kafka/$source/$source.$l_min"
        l_bakdir="$log_backup/$source/$l_day"
        l_bakfile="$l_bakdir/$source.$l_min"
        if [ ! -d "$l_bakdir" ]
        then
            mkdir -p $l_bakdir
            chmod 0755 $l_bakdir
        fi
        check_pid=`ps aux|grep tail|grep $l_file|grep -v grep|awk '{print $2}'`
        if test "$check_pid"
        then
           kill -9 $check_pid
           mv $l_file $l_bakfile
        fi
    done
}

tail2Kafka
sleep 5
stopTail2Kafka
exit
