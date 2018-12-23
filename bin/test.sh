#!/bin/bash

i=0
bar=''
array=('-' '\\' '|' '/')
while [ $i -le 200 ]
do
	let idx=i%4
	printf "\e[31m\033[40m[%-100s]\e[32m\033[47m [%d%%] \e[30m \033[47m [%c] \e[0m\r" "$bar" "$i" "${array[$idx]}"
	bar+='#'
	let i++
done
printf "\n"
