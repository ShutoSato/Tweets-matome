import sys
import MeCab
m = MeCab.Tagger ()
print(m.parse ("すもももももももものうち"))