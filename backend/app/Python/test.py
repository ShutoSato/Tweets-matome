import oseti
import ipadic

tokenizer = MeCab.Model()
analyzer = oseti.Analyzer(mecab_args=ipadic.MECAB_ARGS)
analyzer.analyze('天国で待ってる。')