#include<stdio.h>
#include<ctype.h>
#include<stdbool.h>
#define STOP '|'
int main()
{
    char c; //读入字符
    char prev; //前一个读入字符
    long n_chars = 0L;  //字符数
    int n_lines = 0; //行数
    int n_words = 0; //单词数
    int p_lines = 0; //不完整的行数
    bool inword = false; //如果c在一个单词中inword等于true

    printf("Enter text to be analyzed(| to terminate):\n");
    prev = '\n';   //用于识别完整的行
    while ((c = getchar()) != STOP)
    {
        n_chars++; //统计字符数
        if (c == '\n')
        {
            n_lines++;  //统计行数
        }
        /*
        为了知道一个字符是不是在单词里，可以读入一个单词的首字符时把一个标志（inword）
        设置为1,可以在此处理递增单词计数
        然后inword保持为1,后续的非空白字符就不标记为一个单词的开始。到下一次出现空白字符时，必须
        将此标志置为0。继续下一个单词
        */
        if (!isspace(c) && !inword)    //统计一个单词
        {
            inword = true;
            n_words++;
        }
        if (isspace(c) && inword)  //判断一个单词结尾
        {
            inword = false;
        }
        
        prev = c;
    }
    if (prev != '\n')
    {
        p_lines = 1;
    }
    printf("characters = %ld, words = %d, lines = %d, partial lines = %d",
          n_chars, n_words, n_lines, p_lines);
    return 0;
}
