import { RefObject, useState } from 'react';

interface UseClickDelayOptions {
  delayThreshold?: number;
  allowedMouseButtons?: number[];
}

const useClickDelay = (
  // eslint-disable-next-line
  callback: (event: any) => void,
  // eslint-disable-next-line
  excludeRefs?: RefObject<any>[],
  options?: UseClickDelayOptions
) => {
  const delayThreshold = options && options.delayThreshold ? options.delayThreshold : 200;
  const allowedMouseButtons =
    options && options.allowedMouseButtons ? options.allowedMouseButtons : [0];

  const [mouseDown, setMouseDown] = useState(200);

  const handleMouseDown = () => setMouseDown(+new Date());
  // eslint-disable-next-line
  const handleMouseUp = (event: any) => {
    // TODO: Include includes polyfill
    if (!allowedMouseButtons.includes(event.button)) return;

    let fire = true;
    if (excludeRefs) {
      for (let i = 0; i < excludeRefs.length; i += 1) {
        const ref = excludeRefs[i];
        if (
          ref &&
          ref.current &&
          (event.target === ref.current || ref.current.contains(event.target))
        ) {
          fire = false;
          break;
        }
      }
    }

    if (fire) {
      const mouseUp = +new Date();
      if (mouseUp - mouseDown < delayThreshold) {
        if (callback) callback(event);
      }
    }
  };

  return {
    handleMouseDown,
    handleMouseUp,
  };
};

export default useClickDelay;
