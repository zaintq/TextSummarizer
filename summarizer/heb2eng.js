      function AtStart(i, text) {
        return ((i == 0) || (text.charAt(i-1) == ' '));
      }

      function AtEnd(i, text) {
        return ((i == text.length-1) || (text.charAt(i+1) == ' '));
      }

      function PrevChar(i, text) {
        if (AtStart(i, text)) {
          return "";
        }
        return text.charAt(i-1);
      }

      function NextChar(i, text) {
        if (AtEnd(i, text)) {
          return "";
        }
        return text.charAt(i+1);
      }

      function DisplayEnglish(dialect, text) {
        var sephardic = dialect[0].checked;
        var ashkenazi = dialect[1].checked;
        var yiddish = dialect[2].checked;
        var englishText = [''];
        for (var i=0; i<text.length; i++) {
          var hebrewLetter = text.charAt(i);
          var englishLetter = '';
          if (hebrewLetter == ALEF) {
            if (NextChar(i, text) == VAV || NextChar(i, text) == YUD) {
              continue;
            } else {
              englishLetter = 'A|O';
            }
          } else if (hebrewLetter == BAIS) {
            if (AtStart(i, text) || yiddish) {
              englishLetter = 'B';
            } else {
              englishLetter = 'V|B';
            }
//        } else if (hebrewLetter == VAIS) {
//          englishLetter = 'V';
          } else if (hebrewLetter == GIMEL) {
            englishLetter = 'G';
          } else if (hebrewLetter == DALET) {
            englishLetter = 'D';
          } else if (hebrewLetter == HAY) {
            englishLetter = 'H';
          } else if (hebrewLetter == VAV) {
            if (NextChar(i, text) == VAV) {
              if (yiddish) {
                englishLetter = 'V';
              } else {
                englishLetter = 'W';
              }
              i++;
            } else if (yiddish) {
              englishLetter = 'O|U';
            } else if (AtStart(i, text)) {
              englishLetter = 'V';
            } else if (AtStart(i-1, text) && PrevChar(i, text) == ALEF) {
              englishLetter = 'O|U|AV';
            } else {
              englishLetter = 'O|U|V';
            }
          } else if (hebrewLetter == ZAYIN) {
            englishLetter = 'Z';
          } else if (hebrewLetter == KHESS) {
            englishLetter = 'KH';
          } else if (hebrewLetter == TESS) {
            englishLetter = 'T';
          } else if (hebrewLetter == YUD) {
            if (AtStart(i, text)) {
              if (NextChar(i, text) == ALEF || NextChar(i, text) == AYIN) {
                englishLetter = 'Y';
              } else {
                englishLetter = 'YI';
              }
            } else if (AtEnd(i, text)) {
              englishLetter = 'Y';
            } else if (PrevChar(i, text) == YUD) {
              englishLetter = 'E';
            } else {
              englishLetter = 'I';
            }
          } else if (hebrewLetter == KAF) {
            if (yiddish) {
              englishLetter = 'KH';
            } else if (AtStart(i, text)) {
              englishLetter = 'K';
            } else {
              englishLetter = 'KH|K';
            }
//        } else if (hebrewLetter == KHAF) {
//          englishLetter = 'KH';
          } else if (hebrewLetter == KHAF2) {
            englishLetter = 'KH';
          } else if (hebrewLetter == LAMED) {
            englishLetter = 'L';
          } else if (hebrewLetter == MEM) {
            englishLetter = 'M';
          } else if (hebrewLetter == MEM2) {
            englishLetter = 'M';
          } else if (hebrewLetter == NUN) {
            englishLetter = 'N';
          } else if (hebrewLetter == NUN2) {
            englishLetter = 'N';
          } else if (hebrewLetter == SAMEKH) {
            englishLetter = 'S';
          } else if (hebrewLetter == AYIN) {
            if (yiddish) {
              englishLetter = 'E';
            } else {
              englishLetter = 'A';
            }
          } else if (hebrewLetter == PAY) {
            if (AtStart(i, text)) {
              englishLetter = 'P|F';
            } else {
              englishLetter = 'F|P';
            }
//        } else if (hebrewLetter == FAY) {
//          englishLetter = 'F';
          } else if (hebrewLetter == FAY2) {
            englishLetter = 'F';
          } else if (hebrewLetter == TSADI) {
            englishLetter = 'TZ';
          } else if (hebrewLetter == TSADI2) {
            englishLetter = 'TZ';
          } else if (hebrewLetter == KUF) {
            englishLetter = 'K';
          } else if (hebrewLetter == RAISH) {
            englishLetter = 'R';
          } else if (hebrewLetter == SHIN) {
            if (yiddish) {
              englishLetter = 'SH';
            } else {
              englishLetter = 'SH|S';
            }
//        } else if (hebrewLetter == SIN) {
//          englishLetter = 'S';
          } else if (hebrewLetter == TAF) {
            if (yiddish) {
              englishLetter = '?';
            } else if (AtStart(i, text) || sephardic) {
              englishLetter = 'T';
            } else {
              englishLetter = 'S|T';
            }
//        } else if (hebrewLetter == SAF) {
//          englishLetter = 'S';
          } else if (hebrewLetter == BLANK) {
            englishLetter = ' ';
          }

          var englishLetterArray = englishLetter.split('|'); // array of letter choices to be appended
          letterCount = englishLetterArray.length;
          wordCount = englishText.length;

          // duplicate englishText array for each letter choice to be appended
          for (var letterIndex=1; letterIndex<letterCount; letterIndex++) {
            for (var wordIndex=0; wordIndex<wordCount; wordIndex++) {
              englishText[letterIndex*wordCount + wordIndex] = englishText[wordIndex];
            }
          }

          // append a different letter choice for each of the above duplications in englishText array
          for (var letterIndex=0; letterIndex<letterCount; letterIndex++) {
            for (var wordIndex=0; wordIndex<wordCount; wordIndex++) {
              englishText[letterIndex*wordCount + wordIndex] += englishLetterArray[letterIndex];
            }
          }
        }
        var result = englishText.join(', ');
/* drop this since nobody should be running N4 anymore
        if (navigator.appName == "Netscape" && result.length > 4094) {
          result = "line too long"; // javascript on N4 seems to choke if it's longer than that
        }
*/
        return result;
      }
