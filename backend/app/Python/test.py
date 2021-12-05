import oseti
import ipadic

analyzer = oseti.Analyzer(mecab_args=ipadic.MECAB_ARGS)
a = analyzer.analyze('天国で待ってる。')
print(a)