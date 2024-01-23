import React from 'react';
import { ModalProps } from '../../../props/props';
import ModalBody from './Body';
import ModalFooter from './Footer';
import ModalHeader from './Header';

const Modal: React.FC<React.PropsWithChildren<ModalProps>> = (props: ModalProps): JSX.Element => (
  <div
    className={props.show ? 'modal fade' : 'modal fade hide'}
    id={props.id}
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true"
  >
    <div className="modal-dialog">
      <div className="modal-content">
        <ModalHeader headline={props.headline} text={props.text} />
        <ModalBody>{props.children}</ModalBody>
        <ModalFooter />
      </div>
    </div>
  </div>
);
export default Modal;
