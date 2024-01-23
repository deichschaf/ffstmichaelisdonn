import React from 'react';
import { ModalBodyProps } from '../../../../props/props';

const ModalBody: React.FC<React.PropsWithChildren<ModalBodyProps>> = (
  props: ModalBodyProps,
): JSX.Element => <div className="modal-body">{props.children}</div>;
export default ModalBody;
