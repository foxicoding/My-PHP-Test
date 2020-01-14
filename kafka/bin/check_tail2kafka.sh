#!/bin/bash
log2kafka="/mfw_rundata/log"
log_backup="/mfw_data/log_backup"
kafka_brokers="192.168.4.72:9092,192.168.4.73:9092,192.168.4.74:9092"
log_source="server_event page_event mobile_event monitor_event weapp_event"


c_min=`date +%Y%m%d%H%M`
l_min=`date -d "-1 minutes" +%Y%m%d%H%M`
l_two_min=`date -d "-2 minutes" +%Y%m%d%H%M`
l_day=`echo ${l_min:0:8}`

#tail file
function fileTail() {
     source=$1
     base_file="$log2kafka/$source/$source"
     tail_file="$base_file.$c_min"
     c_sec=`date +%S`
     while [ ! -f "$tail_file" ]
     do
         if [[ ${c_sec} -gt 60 ]];then
                 return
         fi
         let c_sec=c_sec+1
         sleep 1
     done
     check_pid=`ps aux|grep tail|grep ${base_file}|grep  ${c_min}|awk '{print $2}'`
     if ! test ${check_pid}
     then
         tail -n +1 -f ${tail_file}|php logPipeLine.php ${source} &
     fi
}

#backup file
function backupFile(){

   for source in ${log_source}
    do
        c_file="$log2kafka/$source/$source.$c_min"
        l_file="$log2kafka/$source/$source.$l_min"
        l_two_file="$log2kafka/$source/$source.$l_two_min"
        backup_dir="$log_backup/$source/$l_day"
        if [ ! -d "$backup_dir" ]
        then
            mkdir -p ${backup_dir}
            chmod 0755 ${backup_dir}
        fi
        for h_file in ${log2kafka}/${source}/*
        do
            if [ -f ${h_file} -a ${h_file} !=  ${c_file}  -a ${h_file} != ${l_file} -a ${h_file} != ${l_two_file} ]
            then
                 mv ${h_file} ${backup_dir}
            fi
        done
    done
}

#tail log to kafka
function tail2Kafka() {
    for source in  ${log_source}
    do
       fileTail ${source} &
    done
}

#stop tail2kafka
function stopTail2Kafka(){
    for source in ${log_source}
    do
        base_file="$log2kafka/$source/$source"
        check_pid=`ps aux|grep tail|grep ${base_file}|grep -v ${c_min}|grep -v ${l_min}|grep -v ${l_two_min}|awk '{print $2}'`
        if test "$check_pid"
        then
           kill -9 ${check_pid}
        fi
    done
}

tail2Kafka
sleep 10
stopTail2Kafka
backupFile
exit