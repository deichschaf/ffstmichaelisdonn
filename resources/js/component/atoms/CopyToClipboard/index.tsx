import React, { useState } from 'react';
import ErrorBoundary from '../../organisms/errorboundary';
import ButtonFAS from '../Buttons/ButtonFAS';

export interface ICopyToClipboardProps {
  content: string;
}
const CopyToClipboard: React.FC<React.PropsWithChildren<ICopyToClipboardProps>> = (
  props: ICopyToClipboardProps,
): JSX.Element => {
  const [getInfo, setInfo] = useState<boolean>(false);
  const ClickButton = e => {
    e.preventDefault();
    e.clipboardData.setData('Text', props.content);
    setInfo(true);
    setTimeout(() => {
      setInfo(false);
    }, 3000);
  };

  return (
    <ErrorBoundary>
      <div>{props.content}</div>
      <ButtonFAS FAclassName="clipboard-list" onClick={e => ClickButton(e)} title="Copy Text" />
      {getInfo ? <span className="clipboardInfo">Bereich kopiert</span> : <></>}
    </ErrorBoundary>
  );
};
export default CopyToClipboard;
