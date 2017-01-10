
function Blur(canvasID, x1, y1, x2, y2) {
	var context;
    var p1 =1;
    var p2 = 1;
    var p3 = 1;
    var er = 0; // dodatkowa czerwien
    var eg = 0; // dodatkowa zielen
    var eb = 0; // dodatkowy niebieski
    var iBlurRate = 55;
    canvasOrig = document.getElementById(canvasID);
    contextOrig = canvasOrig.getContext('2d');
    context = canvasOrig.getContext('2d');

    var iW = canvasID.width;
    var iM = canvasID.height;


    var imgd = contextOrig.getImageData(x1, y1, x2, y2);
    var data = imgd.data;
    for (br = 0; br < iBlurRate; br += 1) {
        for (var i = 0, n = data.length; i < n; i += 4) {
            iMW = 4 * iW;
            iSumOpacity = iSumRed = iSumGreen = iSumBlue = 0;
            iCnt = 0;
            aCloseData = [
                i - iMW - 4, i - iMW, i - iMW + 4, // gorne
                i - 4, i + 4, // srodkowe
                i + iMW - 4, i + iMW, i + iMW + 4 // dolne
            ];
            for (e = 0; e < aCloseData.length; e += 1) {
                if (aCloseData[e] >= 0 && aCloseData[e] <= data.length - 3) {
                    iSumOpacity += data[aCloseData[e]];
                    iSumRed += data[aCloseData[e] + 1];
                    iSumGreen += data[aCloseData[e] + 2];
                    iSumBlue += data[aCloseData[e] + 3];
                    iCnt += 1;
                }
            }

            data[i] = (iSumOpacity / iCnt)*p1+er;
            data[i+1] = (iSumRed / iCnt)*p2+eg;
            data[i+2] = (iSumGreen / iCnt)*p3+eb;
            data[i+3] = (iSumBlue / iCnt);
        }
    }
    context.putImageData(imgd, x1, y1);
   // console.log("ok");
}