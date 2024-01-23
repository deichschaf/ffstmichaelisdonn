import React, { Component, ErrorInfo, ReactNode } from 'react';
import PageHeadline from '../../atoms/PageHeadline';
import AlertErrorBox from '../../molecules/AlertBox/Error';

interface Props {
  children: ReactNode;
}

interface State {
  hasError: boolean;
  errors: any | undefined;
}

class ErrorBoundary extends Component<Props, State> {
  // eslint-disable-next-line react/state-in-constructor
  public state: State = {
    hasError: false,
    errors: undefined,
  };

  public static getDerivedStateFromError(error: Error) {
    // Update state so the next render will show the fallback UI.
    const errors = [{ error }, { errorInfo: null }, { errorMessage: error.toString() }];
    return { hasError: true, errors };
  }

  public componentDidCatch(error: Error, errorInfo: ErrorInfo) {
    const errors = [{ error }, { errorInfo }, { errorMessage: errorInfo }];
    return { hasError: true, errors };
  }

  public render() {
    if (this.state.hasError) {
      const textarray = [] as any;
      const errorObject = {
        columnNumber: '',
        fileName: '',
        lineNumber: '',
        message: '',
        stack: '',
      };
      if (typeof this.state.errors.error !== 'undefined') {
        textarray.push(this.state.errors.error.toString() as any);
      }
      if (
        typeof this.state.errors.errorInfo !== 'undefined' &&
        this.state.errors.errorInfo !== null
      ) {
        textarray.push(this.state.errors.errorInfo.componentStack as any);
      }
      if (textarray.length === 0) {
        const { errors } = this.state;
        for (let i = 0; i < errors.length; i += 1) {
          if (typeof errors[i].error !== 'undefined') {
            if (errors[i].error !== null && errors[i].error !== '') {
              if (typeof errors[i].error.componentStack !== 'undefined') {
                textarray.push(errors[i].error.componentStack as any);
              } else {
                if (typeof errors[i].error.columnNumber !== 'undefined') {
                  errorObject.columnNumber = errors[i].error.columnNumber;
                }
                if (typeof errors[i].error.fileName !== 'undefined') {
                  errorObject.fileName = errors[i].error.fileName;
                }
                if (typeof errors[i].error.lineNumber !== 'undefined') {
                  errorObject.lineNumber = errors[i].error.lineNumber;
                }
                if (typeof errors[i].error.message !== 'undefined') {
                  errorObject.message = errors[i].error.message;
                }
                if (typeof errors[i].error.stack !== 'undefined') {
                  errorObject.stack = errors[i].error.stack;
                }
              }
            }
          }
          if (typeof errors[i].errorInfo !== 'undefined') {
            if (errors[i].errorInfo !== null && errors[i].errorInfo !== '') {
              if (typeof errors[i].errorInfo.componentStack !== 'undefined') {
                textarray.push(errors[i].errorInfo.componentStack as any);
              } else {
                textarray.push(errors[i].errorInfo as any);
              }
            }
          }
          if (typeof errors[i].errorMessage !== 'undefined') {
            if (errors[i].errorMessage !== null && errors[i].errorMessage !== '') {
              if (typeof errors[i].errorMessage.componentStack !== 'undefined') {
                textarray.push(errors[i].errorMessage.componentStack as any);
              } else {
                textarray.push(errors[i].errorMessage as any);
              }
            }
          }
        }
      }
      return (
        <div className="ErrorBox">
          <PageHeadline label="Sorry.. there was an error" />
          <AlertErrorBox showButton={false} textarray={textarray} errorObject={errorObject} />
        </div>
      );
    }

    return this.props.children;
  }
}

export default ErrorBoundary;
